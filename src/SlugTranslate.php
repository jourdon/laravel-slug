<?php

namespace Jourdon\Slug;

use GuzzleHttp\Client;
use Overtrue\Pinyin\Pinyin;

class SlugTranslate
{
    protected $config;
    public function __construct($config)
    {
        $this->config = $config;
    }

    public function translate($text)
    {
        if($this->isEnglish($text)){
            return $text;
        }

        if (empty($this->config['translate_appid']) || empty($this->config['translate_secret'])) {
            return $this->pinyin($text);
        }

        $salt = time();
        $query=$this->getArgs($this->config['type']);
        $query['q']=$text;
        $query['salt']=$salt;
        $query['sign'] = $this->buildSign($text , $salt);
        $response = $this->call($query);

        if (!$response) {
            return $this->pinyin($text);
        }
        return str_slug($response);
    }

    private function isEnglish($text)
    {
        if (preg_match("/\p{Han}+/u", $text)) {
            return false;
        }
        return true;
    }

    private function getArgs($type)
    {
        if($type=='baidu'){
            return  [
                "from"  => "zh",
                "to"    => "en",
                "appid" => $this->config['translate_appid'],
            ];
        }else{
            return  [
                "from"  => "zh-CHS",
                "to"    => "EN",
                "appKey" => $this->config['translate_appid'],
            ];
        }
    }

    private function buildSign($query, $salt)
    {
        $str = $this->config['translate_appid'] . $query . $salt . $this->config['translate_secret'];
        return   md5($str);
    }

    private  function call($query)
    {
        $http=new Client();
        $response = $http->get($this->config['api'][$this->config['type']].http_build_query($query));
        $re = json_decode($response->getBody(), true);
        return $this->returnType($re);
    }

    private function returnType($data)
    {
        if($this->config['type']=='baidu'){
            return $this->typeOfBaidu($data);
        }else{
            return $this->typeOfYoudao($data);
        }
    }

    private function typeOfBaidu($item)
    {
        return $item['trans_result'][0]['dst'] ?? false;
    }

    private function typeOfYoudao($item)
    {
        return  $item['translation'][0] ?? false;
    }

    private function pinyin($text)
    {
        return str_slug(app(Pinyin::class)->permalink($text));
    }
}