<?php

namespace ThirdParty;

use ThirdParty\Security\Crypto;
use ThirdParty\Support\Miscellaneous;

/**
 * 参考：https://blog.csdn.net/akanswer/article/details/118701594
 */
class Decipher
{
    private $token;
    private $appId;
    private $cryp;

    /**
     * @param string $encodingAesKey 第三方应用的，消息加解密Key
     * @param string $token 第三方应用的，消息校验Token
     * @param string $appId 第三方应用的APPID
     */
    public function __construct($encodingAesKey, $token, $appId)
    {
        if (strlen($encodingAesKey) != 43) {

        }
        $this->cryp = new Crypto($encodingAesKey);
        $this->token = $token;
        $this->appId = $appId;
    }

    //解密消息
    public function decryptMsg($msgSignature, $timestamp, $nonce, $postData)
    {
        //提取密文
        $encrypt = Miscellaneous::xmlExtract(Miscellaneous::xmlFormat($postData));
        //验证安全签名
        $signature = Miscellaneous::getSHA1($this->token, $timestamp, $nonce, $encrypt);
        if ($signature != $msgSignature) {
            return false;
        }
        $plaintext = $this->cryp->decrypt($encrypt, $appid);
        if ($appid != $this->appId) {
            return false;
        }
        return (array)simplexml_load_string($plaintext, 'SimpleXMLElement', LIBXML_NOCDATA);
    }

    //加密消息
    public function encryptMsg($replyMsg, $timeStamp, $nonce)
    {
        //加密
        $encrypt = $this->cryp->encrypt($replyMsg, $this->appId);
        //生成安全签名
        $signature = Miscellaneous::getSHA1($this->token, $timeStamp, $nonce, $encrypt);
        //生成发送的xml
        return Miscellaneous::xmlGenerate($encrypt, $signature, $timeStamp, $nonce);
    }
}