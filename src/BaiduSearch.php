<?php
/**
 * Created by PhpStorm.
 * User: james.xue
 * Date: 2019/5/17
 * Time: 17:54
 */
namespace James\BaiduSearch;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class BaiduSearch
{
    const URL = "http://data.zz.baidu.com/urls?site=%s&token=%s";

    /**
     * Notes:
     * Date: 2019/5/20 9:35
     * @param array $params
     * @return array|bool|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * 请求成功返回字段
     * 字段 	        是否必选 	参数类型 	说明
     * success 	        是 	        int 	    成功推送的url条数
     * remain 	        是 	        int 	    当天剩余的可推送url条数
     * not_same_site 	否 	        array 	    由于不是本站url而未处理的url列表
     * not_valid 	    否 	        array 	    不合法的url列表
     *
     * 请求失败返回字段
     * 字段 	是否必传 	类型 	说明
     * error 	是 	        int 	错误码，与状态码相同
     * message 	是 	        string 	错误描述
     */
    public function run(array $params = [])
    {
        $url = sprintf(self::URL , config('baidu.site'), config('baidu.token'));

        $data = implode("\n", $params);
        $client = new Client();
        $response = $client->request('POST', $url, [
            'body' => $data
        ]);

        $result = json_decode($response->getBody()->getContents() , 1);
        if (isset($result['success'])) {
            return true;
        } else {
            $message = isset($result['message']) ? $result['message'] : '未知错误';
            Log::error('baidu-search：'.json_encode($message, JSON_UNESCAPED_UNICODE));
            return false;
        }
    }
}