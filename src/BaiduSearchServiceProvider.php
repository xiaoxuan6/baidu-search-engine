<?php
/**
 * Created by PhpStorm.
 * User: james.xue
 * Date: 2019/5/17
 * Time: 18:02
 */
namespace James\BaiduSearch;

use Illuminate\Support\ServiceProvider;

class BaiduSearchServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([__DIR__.'/../config/baidu.php' => config_path('baidu.php')], 'config');

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('BaiduSearch', function(){
            return new BaiduSearch();
        });

        class_alias ( '\James\BaiduSearch\Facades\BaiduSearch' , 'BaiduSearch');
    }
}