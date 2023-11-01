<?php


/**
 * 公众号回调示例
 */
class GzhController
{
    public function index()
    {
        define("TOKEN", '60cb1c91554f8');
        $this->valid();
    }

    public function valid()
    {
        $echoStr = isset($_GET["echostr"]) ? $_GET['echostr'] : '';
        if (!$this->checkSignature()) {
            exit('无效的访问！' . date('Y-m-d H:i:s'));
        }
        echo $echoStr;
        try {
            $this->responseMsg();
        } catch (\Throwable $e) {
            SQLHelper::insert('wx_callback_log', ['type' => 'catch_error', 'content' => $e->getMessage()]);
        }
        exit();
    }

    //验证是否微信发送消息
    private function checkSignature()
    {
        $signature = isset($_GET["signature"]) ? $_GET['signature'] : '';
        $timestamp = isset($_GET["timestamp"]) ? $_GET['timestamp'] : '';
        $nonce = isset($_GET["nonce"]) ? $_GET['nonce'] : '';
        $tmpArr = array(TOKEN, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = sha1(implode($tmpArr));
        if ($tmpStr == $signature) {
            return true;
        }
        return false;
    }

    //对收到消息进行判断返回消息
    public function responseMsg()
    {
        $postStr = file_get_contents('php://input');
        if (empty($postStr)) {
            SQLHelper::insert('wx_callback_log', ['type' => 'error', 'content' => 'empty postStr']);
            return;
        }
        $msg = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
        SQLHelper::insert('wx_callback_log', [
            'type' => empty($msg->MsgType) ? '' : $msg->MsgType,
            'event' => empty($msg->Event) ? '' : $msg->Event,
            'event_key' => empty($msg->EventKey) ? '' : $msg->EventKey,
            'from_user' => $msg->FromUserName,//发送方帐号（一个OpenID）
            'to_user' => $msg->ToUserName,//开发者
        ]);
        if ('event' === trim($msg->MsgType)) {
            (new EventService($msg))->work();
        }
        if ('text' === trim($msg->MsgType)) {
            (new TextService($msg))->work();
        }
    }
}
