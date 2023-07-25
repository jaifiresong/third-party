<?php


namespace ThirdParty;


use ThirdParty\Promise\CurlPromise;
use ThirdParty\Promise\ParamPromise;

class ThirdParty
{
    private $param;
    private $curl;

    public function __construct(ParamPromise $param, CurlPromise $curl)
    {
        $this->param = $param;
        $this->curl = $curl;
    }

    /**
     * https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/2.0/api/ThirdParty/token/component_access_token.html
     * 步骤二：获取平台token
     * 令牌的获取是有限制的，每个令牌的有效期为 2 小时
     * 如未特殊说明，令牌一般作为被调用接口的 GET 参数 component_access_token 的值使用
     */
    public function api_component_token()
    {
        $api = "https://api.weixin.qq.com/cgi-bin/component/api_component_token";
        $params = [
            'component_appid' => $this->param->component_appid(),//第三方平台 appid
            'component_appsecret' => $this->param->component_appsecret(),//第三方平台 appsecret
            'component_verify_ticket' => $this->param->component_verify_ticket(),//微信后台推送的 ticket
        ];
        return $this->curl->post($api, $params);
    }

    /**
     * https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/2.0/api/ThirdParty/token/pre_auth_code.html
     * 步骤三： 获取预授权码
     * 预授权码第三方平台方实现授权托管的必备信息，每个预授权码有效期为 1800秒
     *
     * https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/2.0/api/Before_Develop/Authorization_Process_Technical_Description.html#_1%E3%80%81%E6%8E%88%E6%9D%83%E9%93%BE%E6%8E%A5%E5%8F%82%E6%95%B0%E8%AF%B4%E6%98%8E
     * 步骤四：拼接授权地址
     */
    public function componentLoginPage($redirect_uri, $auth_type = 1)
    {
        $api = "https://api.weixin.qq.com/cgi-bin/component/api_create_preauthcode?component_access_token=" . $this->param->get_component_access_token();
        $params = [
            'component_appid' => $this->param->component_appid(),//第三方平台 appid
        ];
        $preauthcode = $this->curl->preAuthCodePost($api, $params);

        // 组装授权地址
        $query = [
            'component_appid' => $this->param->component_appid(), //第三方平台方 appid
            'pre_auth_code' => $preauthcode, //预授权码
            'redirect_uri' => $redirect_uri, //管理员授权确认之后会自动跳转进入回调 URI，并在 URL 参数中返回授权码和过期时间(redirect_url?auth_code=xxx&expires_in=600)
            'auth_type' => $auth_type, //要授权的帐号类型:1 表示手机端仅展示公众号；2 表示仅展示小程序，3 表示公众号和小程序都展示
        ];
        return "https://mp.weixin.qq.com/cgi-bin/componentloginpage?" . http_build_query($query);
    }

    //##############################################//以下为授权后的接口//##############################################

    /**
     * https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/2.0/api/ThirdParty/token/authorization_info.html
     * 获取被开发方的TOKEN
     * 管理员扫码后，回调数据会带 authorization_code 使用它来获取被开发方的TOKEN
     * @param $authorization_code
     */
    public function authorizer_access_token($authorization_code)
    {
        $api = "https://api.weixin.qq.com/cgi-bin/component/api_query_auth?component_access_token=" . $this->param->get_component_access_token();
        $params = [
            'component_appid' => $this->param->component_appid(),//第三方平台 appid
            'authorization_code' => $authorization_code,//授权码, 会在授权成功时返回给第三方平台
        ];
        return $this->curl->post($api, $params);
    }

    /**
     * https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/2.0/api/ThirdParty/token/api_authorizer_token.html
     * 刷新被开发方的TOKEN
     * @param $authorizer_appid
     * @param $authorizer_refresh_token
     */
    public function refresh_authorizer_token($authorizer_appid, $authorizer_refresh_token)
    {
        $api = "https://api.weixin.qq.com/cgi-bin/component/api_authorizer_token?component_access_token=" . $this->param->get_component_access_token();
        $params = [
            'component_appid' => $this->param->component_appid(),
            'authorizer_appid' => $authorizer_appid,
            'authorizer_refresh_token' => $authorizer_refresh_token,
        ];
        return $this->curl->post($api, $params);
    }
}