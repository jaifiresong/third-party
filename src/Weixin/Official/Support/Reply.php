<?php


namespace ReqTencent\Weixin\Official\Support;


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

    public static function makeImg($media_id, $toUser, $fromUser)
    {
        $CreateTime = time();
        return "<xml>
                  <ToUserName><![CDATA[$toUser]]></ToUserName>
                  <FromUserName><![CDATA[$fromUser]]></FromUserName>
                  <CreateTime>$CreateTime</CreateTime>
                  <MsgType><![CDATA[image]]></MsgType>
                  <Image>
                    <MediaId><![CDATA[$media_id]]></MediaId>
                  </Image>
                </xml>";
    }

    public static function makeGraphic(array $data, $toUser, $fromUser)
    {
        $CreateTime = time();
        $count = count($data);
        $articles = '';
        foreach ($data as $item) {
            $pic = $item['pic']; //图文件封面
            $url = $item['url']; //图文详情
            $articles .= "<item>
                              <Title><![CDATA[{$item['title']}]]></Title>
                              <Description><![CDATA[{$item['description']}]]></Description>
                              <PicUrl><![CDATA[{$pic}]]></PicUrl>
                              <Url><![CDATA[{$url}]]></Url>
                            </item>";
        }
        return "<xml>
                  <ToUserName><![CDATA[$toUser]]></ToUserName>
                  <FromUserName><![CDATA[$fromUser]]></FromUserName>
                  <CreateTime>$CreateTime</CreateTime>
                  <MsgType><![CDATA[news]]></MsgType>
                  <ArticleCount>$count</ArticleCount>
                  <Articles>
                        $articles
                  </Articles>
                </xml>";
    }
}