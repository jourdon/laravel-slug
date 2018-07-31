# Slug
[![Latest Stable Version](https://poser.pugx.org/jourdon/slug/v/stable)](https://packagist.org/packages/jourdon/slug)
[![Total Downloads](https://poser.pugx.org/jourdon/slug/downloads)](https://packagist.org/packages/jourdon/slug)
[![License](https://poser.pugx.org/jourdon/slug/license)](https://packagist.org/packages/jourdon/slug)

## 说明

Slug 整合了百度翻译与有道翻译,你可以选择使用其中一个平台来实现翻译的功能,当然，如果翻译失败的情况下，我们还有备用的方案，可以转换成拼音。

使用这个安装包的前提是你需要在这两个平台注册并申请应用：

- http://ai.youdao.com/product-fanyi.s
- http://api.fanyi.baidu.com/api/trans/product/prodinfo#0

你需要拿到这两个关键信息:

1. app ID
2. app Secret


## 安装

使用 Composer 安装:

```bash
composer require jourdon/slug
```
导出配置文件
```bash
php artisan vendor:publish --provider="Jourdon\Slug\SlugServiceProvider"
```
配置文件内容如下：
```php

return [
    //翻译类型只有两种 "baidu", "youdao"

    'type'  =>  env('TRANSLATE_TYPE','baidu'),

    //翻译 API 地址
    'api' => [
        'baidu' =>  'http://api.fanyi.baidu.com/api/trans/vip/translate?',
        'youdao'=>  'https://openapi.youdao.com/api?'
    ],

    //App id 
    'translate_appid' => env('TRANSLATE_APPID',''),

    //APP secret 
    'translate_secret'   => env('TRANSLATE_SECRET',''),
];
```

接下来，你需要在 `.env` 文件中添加:

```php
TRANSLATE_TYPE=baidu.com
TRANSLATE_APPID=
TRANSLATE_SECRET=
```
将你在平台注册得到的信息添进去即可，当然，`TRANSLATE_TYPE` 这里是你注册平台

>**重点**：如果没有导出配置，或者env 文件中配置项没有正确填写，会默认转成拼音


在 `config/app.php`的 `providers`数组中加入

```php
\Jourdon\Slug\SlugServiceProvider::class,
```
在 `config/app.php`的 `aliases`数组中加入
```
'Slug'  => \Jourdon\Slug\Slug::class,
```
> 如果你使用的是 `laravel 5.5` 版本以上，那面上面的两步可以忽略。


## 使用

```php
use Slug;

Slug::translate('php是世界上最好的语言');
//php-is-the-best-language-in-the-world

```

