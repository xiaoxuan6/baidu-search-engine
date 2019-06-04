## Installation

This package can be installed through Composer.

```
composer require james.xue/baidu-search-engine
```
## 添加服务
在config/app.php文件中添加服务

~~~
'providers' => [
    ....
    James\BaiduSearch\BaiduSearchServiceProvider::class
]
~~~

## 发布扩展文件

~~~
php artisan vendor:publish --tag=config
~~~

## 使用
~~~
$result = \BaiduSearch::run(['https://www.baidu.com/s?ie=utf-8&f=8&rsv_bp=1&rsv_idx=2&tn=baiduhome_pg&wd=123']);
~~~