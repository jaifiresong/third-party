<?php

namespace Official\Support;

use Official\Contracts\BaseInterface;

class Common
{
    /**
     * 获取 token
     * 公众号和小程序是一样的
     * @param BaseInterface $promise
     */
    public static function getAccessToken(BaseInterface $promise)
    {
        $query = [
            'grant_type' => 'client_credential',
            'appid' => $promise->appid(),
            'secret' => $promise->secret(),
        ];
        return $promise->get('https://api.weixin.qq.com/cgi-bin/token?' . http_build_query($query));
    }

    /**
     * 验证是否微信发送消息
     * @param $signature
     * @param $timestamp
     * @param $nonce
     * @param $token
     * @return bool
     */
    public static function checkMsgSignature($signature, $timestamp, $nonce, $token): bool
    {
        $arr = array($token, $timestamp, $nonce);
        sort($arr, SORT_STRING);
        if (sha1(implode($arr)) === $signature) {
            return true;
        }
        return false;
    }

    /**
     * 接收微信服务器推送的信息
     */
    public static function receiveMsg()
    {
        $input = file_get_contents('php://input');
        return simplexml_load_string($input, 'SimpleXMLElement', LIBXML_NOCDATA);
    }
}