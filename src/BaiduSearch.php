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
    const CREATE_URL = "http://data.zz.baidu.com/urls?site=%s&token=%s";
    const UPDATE_URL = "http://data.zz.baidu.com/update?site=%s&token=%s";
    const DELETE_URL = "http://data.zz.baidu.com/del?site=%s&token=%s";

    /**
     * Notes: 创建数据
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
    public function run($params)
    {
        $params = is_array($params) ? $params : (array)$params;

        $url = sprintf(self::CREATE_URL , config('baidu.site'), config('baidu.token'));

        $result = self::request($url, $params);

        return $this->message($result);
    }

    /**
     * Notes: 更新数据
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
    public function update($params)
    {
        $params = is_array($params) ? $params : (array)$params;

        $url = sprintf(self::UPDATE_URL , config('baidu.site'), config('baidu.token'));

        $result = self::request($url, $params);

        return $this->message($result);
    }

    /**
     * Notes: 删除数据
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
    public function delete($params)
    {
        $params = is_array($params) ? $params : (array)$params;

        $url = sprintf(self::DELETE_URL , config('baidu.site'), config('baidu.token'));

        $result = self::request($url, $params);

        return $this->message($result);
    }

    /**
     * Notes: 请求体
     * Date: 2019/9/10 11:03
     * @param $url 百度提交地址
     * @param $params 需要提交的地址
     * @return mixed
     */
    protected static function request($url, $params)
    {
        $ch = curl_init();
        $options =  array(
            CURLOPT_URL => $url,
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => implode("\n", $params),
            CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
        );
        curl_setopt_array($ch, $options);
        $result = curl_exec($ch);
        return json_decode($result, 1);
    }

    /**
     * Notes:
     * Date: 2019/6/4 16:46
     * @param int $code
     * @param string $message
     * @return array
     */
    protected function message($result)
    {
        if(isset($result['error'])){
            return [
                'code' => 401,
                'message' => $result['message'],
                'remain' => '',
            ];
        } elseif(!empty($result->not_same_site)){
            return [
                'code' => 401,
                'message' => '由于不是本站url而未处理的url列表',
                'remain' => '',
            ];
        } elseif(!empty($result->not_valid)){
            return [
                'code' => 401,
                'message' => '不合法的url列表',
                'remain' => '',
            ];
        }else{
            return [
                'code' => 200,
                'message' => '推送成功',
                'remain' => $result,
            ];
        }
    }
}