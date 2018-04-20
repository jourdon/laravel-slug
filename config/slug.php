<?php

return [
    //type of translation
    // Supported: "baidu", "youdao"

    'type'  =>  env('TRANSLATE_TYPE','baidu'),

    //Translate API HTTPS address
    'api' => [
        'baidu' =>  'http://api.fanyi.baidu.com/api/trans/vip/translate?',
        'youdao'=>  'https://openapi.youdao.com/api?'
    ],

    //App id of the translation api
    'translate_appid' => env('TRANSLATE_APPID',''),

    //secret of the translation api
    'translate_secret'   => env('TRANSLATE_SECRET',''),
];