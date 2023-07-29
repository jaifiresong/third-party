<?php

namespace ReqTencent\Weixin\ThirdParty\Support;


class Miscellaneous
{
    //xml格式化
    public static function xmlFormat($xml)
    {
        $xmlTree = new \DOMDocument();
        $xmlTree->loadXML($xml);
        $encrypt = trim($xmlTree->getElementsByTagName('Encrypt')->item(0)->nodeValue);
        $format = "<xml><ToUserName><![CDATA[toUser]]></ToUserName><Encrypt><![CDATA[%s]]></Encrypt></xml>";
        return sprintf($format, $encrypt);
    }

    //xml提取
    public static function xmlExtract($xmlText)
    {
        try {
            $xml = new \DOMDocument();
            $xml->loadXML($xmlText);
            return trim($xml->getElementsByTagName('Encrypt')->item(0)->nodeValue);
        } catch (\Exception $e) {
            return false;
        }
    }

    //xml生成
    public static function xmlGenerate($encrypt, $signature, $timestamp, $nonce)
    {
        $format = "<xml><Encrypt><![CDATA[%s]]></Encrypt><MsgSignature><![CDATA[%s]]></MsgSignature><TimeStamp>%s</TimeStamp><Nonce><![CDATA[%s]]></Nonce></xml>";
        return sprintf($format, $encrypt, $signature, $timestamp, $nonce);
    }

    //SHA1算法
    public static function getSHA1($token, $timestamp, $nonce, $encryptMsg)
    {
        $array = array($encryptMsg, $token, $timestamp, $nonce);
        sort($array, SORT_STRING);
        $str = implode($array);
        return sha1($str);
    }
}