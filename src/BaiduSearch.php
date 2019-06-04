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
    public function run($params)
    {
        $params = is_array($params) ? $params : (array)$params;

        $url = sprintf(self::URL , config('baidu.site'), config('baidu.token'));

        $data = implode("\n", $params);

        $ch = curl_init();
        $options =  array(
            CURLOPT_URL => $url,
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => implode("\n", $data),
            CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
        );
        curl_setopt_array($ch, $options);
        $result = curl_exec($ch);
        $result = json_decode($result, 1);

        if(isset($result['error']))
            return $this->message(401, $result['message']);
        elseif(!empty($result->not_same_site))
            return $this->message(401, '由于不是本站url而未处理的url列表');
        elseif(!empty($result->not_valid))
            return $this->message(401, '不合法的url列表');
        else
            return $this->message(200, '推送成功', $result['remain']);
    }

    /**
     * Notes:
     * Date: 2019/6/4 16:46
     * @param int $code
     * @param string $message
     * @return array
     */
    protected function message($code = 200, $message = '', $remain = '')
    {
        return [
            'code' => $code,
            'message' => $message,
            'remain' => $remain,
        ];
    }
}