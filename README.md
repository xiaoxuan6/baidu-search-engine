## Installation

This package can be installed through Composer.

```
composer require james.xue/baidu-search-engine
```

## 添加服务
在config/app.php文件中添加服务

### 添加 service provider（optional. if laravel < 5.5）

~~~
'providers' => [
    ....
    James\BaiduSearch\BaiduSearchServiceProvider::class
]
~~~

### 添加 alias（optional. if laravel < 5.5）

```
'aliases' => [
    ...
    "BaiduSearch": "James\BaiduSearch\Facades\BaiduSearch::class"
],
```

## 发布扩展文件

~~~
php artisan vendor:publish --tag=baidu
~~~

## 使用

创建：
~~~
$result = \BaiduSearch::run(['https://www.baidu.com/s?ie=utf-8&f=8&rsv_bp=1&rsv_idx=2&tn=baiduhome_pg&wd=123']);
~~~

更新：
~~~
$result = \BaiduSearch::update(['https://www.baidu.com/s?ie=utf-8&f=8&rsv_bp=1&rsv_idx=2&tn=baiduhome_pg&wd=123']);
~~~

删除：
~~~
$result = \BaiduSearch::delete(['https://www.baidu.com/s?ie=utf-8&f=8&rsv_bp=1&rsv_idx=2&tn=baiduhome_pg&wd=123']);
~~~