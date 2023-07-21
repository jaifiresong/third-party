<?php


namespace ThirdParty;


class AuthorizerToken
{
    private $api_component_token;
    private $component_appid;

    public function __construct($api_component_token, $component_appid)
    {
        $this->api_component_token = $api_component_token;
        $this->component_appid = $component_appid;
    }

    /**
     * https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/2.0/api/ThirdParty/token/authorization_info.html
     * 获取被开发方的TOKEN
     * 管理员扫码后，回调数据会带 authorization_code 使用它来获取被开发方的TOKEN
     * @param $authorization_code
     * @return array
     */
    public function authorizer_access_token($authorization_code)
    {
        $api = "https://api.weixin.qq.com/cgi-bin/component/api_query_auth?component_access_token=" . $this->api_component_token;
        $params = [
            'component_appid' => $this->component_appid,//第三方平台 appid
            'authorization_code' => $authorization_code,//授权码, 会在授权成功时返回给第三方平台
        ];
        return [$api, $params];
    }

    /**
     * https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/2.0/api/ThirdParty/token/api_authorizer_token.html
     * 刷新被开发方的TOKEN
     * @param $authorizer_appid
     * @param $authorizer_refresh_token
     * @return array
     */
    public function refresh_authorizer_token($authorizer_appid, $authorizer_refresh_token)
    {
        $api = "https://api.weixin.qq.com/cgi-bin/component/api_authorizer_token?component_access_token=" . $this->api_component_token;
        $params = [
            'component_appid' => $this->component_appid,
            'authorizer_appid' => $authorizer_appid,
            'authorizer_refresh_token' => $authorizer_refresh_token,
        ];
        return [$api, $params];
    }

}