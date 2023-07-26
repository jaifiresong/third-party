<?php


class WxAide
{
    protected $appid;
    protected $appsecret;

    protected $accessToken;

    public function __construct()
    {
        $this->appid = cfg('wx.appid');
        $this->appsecret = cfg('wx.app_secret');
        $this->accessToken = $this->getAccessToken();
    }

    private function getAccessToken()
    {
        $api = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=' . $this->appid . '&secret=' . $this->appsecret;
        $rsp = Lite::request()->get($api);
        $arr = json_decode($rsp, true);
        if (empty($arr['access_token'])) {
            trigger_error("取得access_token出错：$rsp", E_USER_ERROR);
        }
    }

    private function getJsApiTicket()
    {
        $api = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token={$this->accessToken}";
        $rsp = Lite::request()->get($api);
        $arr = json_decode($rsp, true);
        if (empty($arr['ticket'])) {
            trigger_error("取得分享签名的ticket出错：$rsp", E_USER_ERROR);
        }
    }

    public function sdkSignPackage($url = null)
    {
        $jsapiTicket = $this->getJsApiTicket();
        $nonceStr = substr(str_shuffle('qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM1234567890'), 0, 16);
        $timestamp = time();
        if (is_null($url)) {
            $url = domain() . $_SERVER['REQUEST_URI'];
        }
        // 这里参数的顺序要按照 key 值 ASCII 码升序排序
        $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";
        $signature = sha1($string);
        return [
            "url" => $url,
            "appId" => $this->appid,
            "nonceStr" => $nonceStr,
            "timestamp" => $timestamp,
            "signature" => $signature,
            "rawString" => $string
        ];
    }

    //组装授权登录地址：https://developers.weixin.qq.com/doc/offiaccount/OA_Web_Apps/Wechat_webpage_authorization.html#%E7%9B%AE%E5%BD%95
    public static function oauth2($appid, $scope, $current_url)
    {
        $_ = [1 => 'snsapi_base', 2 => 'snsapi_userinfo'];
        $query = http_build_query([
            'appid' => $appid,
            'scope' => $_[$scope],
            'redirect_uri' => $current_url, // 注意不能urlencode
            'response_type' => 'code', // 固定参数
            'state' => '0', // 重定向后会带上state参数，开发者可以填写a-zA-Z0-9的参数值，最多128字节
        ]);
        return "https://open.weixin.qq.com/connect/oauth2/authorize?$query#wechat_redirect";
    }

    public function a()
    {
        $url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=' . $this->appid . '&secret=' . $this->app_secret . '&code=' . $code . '&grant_type=authorization_code';
        $rsp = Lite::request()->get($url);
        $arr = json_decode($rsp, true);
        if (empty($arr['openid']) || empty($arr['unionid'])) {
            return ['status_code' => 2002, 'message' => '登录失败', 'rsp' => $rsp];
        }
    }

    public function b(){
        $rsp = Lite::request()->get("https://api.weixin.qq.com/sns/userinfo?access_token={$arr['access_token']}&openid={$arr['openid']}");
        Log::info($arr['openid'] . '@' . $rsp);
        $info = json_decode($rsp, true);

        if (!empty($info['headimgurl'])) {
            $up['head_img'] = $info['headimgurl'];
            $user['head_img'] = $info['headimgurl'];
        }
        if (!empty($info['nickname'])) {
            $up['nickname'] = $info['nickname'];
            $user['nickname'] = $info['nickname'];
        }

    }
}
