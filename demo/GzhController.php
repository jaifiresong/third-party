<?php


/**
 * 公众号回调示例
 */
class GzhController
{
    public function index()
    {
        $this->valid();
    }

    public function valid()
    {
        $echoStr = isset($_GET["echostr"]) ? $_GET['echostr'] : '';
        if (!checkSignature()) {
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
}
