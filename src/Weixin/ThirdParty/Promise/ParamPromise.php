<?php

namespace ThirdParty\Promise;


interface ParamPromise
{
    /**
     * 平台APPID
     */
    public function component_appid();

    /**
     * 平台secret
     */
    public function component_appsecret();

    /**
     * 在第三方平台创建审核通过后，微信服务器会向其 ”授权事件接收URL” 每隔 10 分钟以 POST 的方式推送 component_verify_ticket
     */
    public function component_verify_ticket();

    /**
     * 获取平台token
     */
    public function get_component_access_token();
}