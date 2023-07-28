<?php


namespace Test\Feeds;

use Official\Contracts\GzhApiInterface;
use Official\Support\Common;

class GzhConfig implements GzhApiInterface
{

    private $appid;

    public function __construct($appid)
    {
        //Crud::db()->select('tpp_authorizer_token')->prep()->one();
        $this->appid = $appid;
    }

    public function appid()
    {
        return $this->appid;
    }

    public function secret()
    {
        return '';
    }

    public function get_access_token()
    {
        return '71_muO3EPhRM-S63N-5IM4x-jAIu_XOHJCrzsrUdZZOZkpnFfZUq0RtQ6BsXcrgfcslUktqb8U0XfoKVmRcjP4btLLK_mBB7uy9C4Xicndp2pVPHOsNX-HSKgg0VGUBFChAIANRO';
    }

    public function get($api)
    {
        return $this->Cget($api);
    }

    public function post($api, $json)
    {
        return $this->Cpost($api, $json);
    }

    public function get_jsapi_ticket()
    {
        // TODO: Implement get_jsapi_ticket() method.
    }

    /**
     * post请求
     * @param string $url
     * @param array $data
     * @param int $timeout
     * @return string 返回页面结果
     */
    public function Cpost($url, $data, $timeout = 5)
    {
        $curl = curl_init(); // 启动一个CURL会话
        curl_setopt($curl, CURLOPT_TIMEOUT, $timeout); // 设置超时限制防止死循环
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); //如果没有这个curl_exec会执行显示操作
        curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); // 对认证证书来源的检查
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE); // 从证书中检查SSL加密算法是否存在
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)'); // 模拟用户使用的浏览器
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
        curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包,是一个数组
        //curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
        //curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
        $res = curl_exec($curl); // 执行操作(里面有了输出显示的操作了，可以使用CURLOPT_RETURNTRANSFER让其不显示)
        if (curl_errno($curl)) {
            echo 'Errno：' . curl_error($curl); //捕抓异常
        }
        curl_close($curl); // 关闭CURL会话
        return $res;
    }

    /**
     * get请求
     * @param string $url
     * @param int $timeout
     * @return string 返回页面结果
     */
    public function Cget($url, $timeout = 15)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $contents = curl_exec($ch);
        curl_close($ch);
        return $contents;
    }

}