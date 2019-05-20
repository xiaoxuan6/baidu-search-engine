<?php
/**
 * Created by PhpStorm.
 * User: james.xue
 * Date: 2019/5/17
 * Time: 18:21
 */
namespace James\BaiduSearch\Facades;

use Illuminate\Support\Facades\Facade;

class BaiduSearch extends Facade
{
    public static function getFacadeAccessor()
    {
        return "BaiduSearch";
    }
}