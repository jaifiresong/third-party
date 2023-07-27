<?php


namespace Official\Support;


class Reply
{
    /**
     * https://developers.weixin.qq.com/doc/offiaccount/Message_Management/Passive_user_reply_message.html#%E5%9B%9E%E5%A4%8D%E6%96%87%E6%9C%AC%E6%B6%88%E6%81%AF
     * 公众号回复文本消息
     */
    public static function makeText($content, $toUser, $fromUser)
    {
        $CreateTime = time();
        //注：FromUserName 为开发者微信号
        return "<xml>
                  <ToUserName><![CDATA[$toUser]]></ToUserName>
                  <FromUserName><![CDATA[$fromUser]]></FromUserName>
                  <CreateTime>$CreateTime</CreateTime>
                  <MsgType><![CDATA[text]]></MsgType>
                  <Content><![CDATA[$content]]></Content>
                </xml>";
    }
}