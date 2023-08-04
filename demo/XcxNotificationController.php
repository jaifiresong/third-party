<?php

namespace App\WxCallback\Controllers;
/**
 * 小程序回调，异步校验图片/音频是否含有违法违规内容。
 */
class XcxNotificationController
{
    public $token = '5Ie0ILiJxsfT';
    public $EncodingAESKey = 'd9AHaUzC3zb9LfjDNN5Ie0ILiJxsfTfnrHwXCxFd3j7';

    public function index()
    {
        define("TOKEN", '5Ie0ILiJxsfT');
        $this->valid();
    }

    private function valid()
    {
        $echoStr = isset($_GET["echostr"]) ? $_GET['echostr'] : '';
        if (!$this->checkSignature()) {
            exit('无效的访问！' . date('Y-m-d H:i:s'));
        }
        echo $echoStr;
        try {
            $this->responseMsg();
        } catch (\Throwable $e) {

        }
    }

    //对收到消息进行判断返回消息
    private function responseMsg()
    {
        $postStr = file_get_contents('php://input');
        $msg = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
        $plain = (new WxCrypt($this->EncodingAESKey))->decrypt($msg->Encrypt);
        $xml = simplexml_load_string($plain, 'SimpleXMLElement', LIBXML_NOCDATA);
        $data = json_decode(json_encode($xml), true);
        if (!empty($data['Event']) && 'wxa_media_check' == $data['Event']) {
            $this->mediaCheck($data, $plain);
        }
    }
}
