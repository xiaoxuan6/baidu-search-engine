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
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/baidu.php' => config_path('baidu.php')
        ], 'baidu');

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

        $this->app->alias(BaiduSearch::class , 'BaiduSearch');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ["BaiduSearch"];
    }
}