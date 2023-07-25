<?php

use ThirdParty\Decipher;

class CallbackController
{
    private $dec;

    public function __construct()
    {
        $conf = [
            'component_appid' => '',
            'component_appsecret' => '',
            'component_encodingAesKey' => '',
            'component_token' => '',
        ];
        $this->dec = new Decipher(
            $conf['component_encodingAesKey'],
            $conf['component_token'],
            $conf['component_appid']
        );
    }

    /**
     * https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/2.0/api/Before_Develop/component_verify_ticket.html
     * 步骤一：接收 component_verify_ticket
     * 在第三方平台创建审核通过后，微信服务器会向其 ”授权事件接收URL” 每隔 10 分钟以 POST 的方式推送 component_verify_ticket
     * 接收 POST 请求后，只需直接返回字符串 success。
     * component_verify_ticket 的有效时间为12小时
     */
    public function component_verify_ticket()
    {
        $get = $_GET;
        $xml = file_get_contents("php://input");
        $arr = $this->dec->decryptMsg($get['msg_signature'], $get['timestamp'], $get['nonce'], $xml);
        if (!empty($arr['InfoType'])) {
            //推送ticket
            if ('component_verify_ticket' === $arr['InfoType']) {
                //SQLSuid::insert('tpp', $arr);
            }

            //授权
            if ('authorized' === $arr['InfoType']) {
                //SQLSuid::insert('tpp', $arr);
                //$arr['AuthorizationCode']
            }
        }

        return 'success';
    }

    /**
     * 授权以后，公众号或小程序的事件会推送到这里
     */
    public function msg()
    {
        $get = $_GET;
        $xml = file_get_contents("php://input");
        $arr = $this->dec->decryptMsg($get['msg_signature'], $get['timestamp'], $get['nonce'], $xml);
        return 'success';
    }
}