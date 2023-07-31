<?php


namespace Test\Feeds;


use ReqTencent\Weixin\ThirdParty\Contracts\ThirdPartyInterface;

class TpConfig implements ThirdPartyInterface
{

    public function component_appid()
    {
        // TODO: Implement component_appid() method.
    }

    public function component_appsecret()
    {
        // TODO: Implement component_appsecret() method.
    }

    public function component_verify_ticket()
    {
        // TODO: Implement component_verify_ticket() method.
    }

    public function get_pre_auth_code()
    {
        // TODO: Implement get_pre_auth_code() method.
    }

    public function get_component_access_token()
    {
        // TODO: Implement get_component_access_token() method.
    }

    public function get_authorizer_access_token($authorizer_appid)
    {
        // TODO: Implement get_authorizer_access_token() method.
    }

    public function post($url, $params)
    {
        // TODO: Implement post() method.
    }
}