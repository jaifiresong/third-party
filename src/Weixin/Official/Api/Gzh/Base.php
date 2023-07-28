<?php


namespace Official\Api\Gzh;

use Official\Contracts\GzhApiInterface;

class Base
{
    private $token;
    private $promise;

    public function __construct(GzhApiInterface $promise)
    {
        $this->token = $promise->get_access_token();
        $this->promise = $promise;
    }

    /**
     * https://developers.weixin.qq.com/doc/offiaccount/OA_Web_Apps/Wechat_webpage_authorization.html#%E7%9B%AE%E5%BD%95
     * 组装授权登录地址
     */
    public function oauth2Authorize($scope, $current_url)
    {
        $_ = [1 => 'snsapi_base', 2 => 'snsapi_userinfo'];
        $query = http_build_query([
            'appid' => $this->promise->appid(),
            'scope' => $_[$scope],
            'redirect_uri' => $current_url, // 注意不能urlencode
            'response_type' => 'code', // 固定参数
            'state' => '0', // 重定向后会带上state参数，开发者可以填写a-zA-Z0-9的参数值，最多128字节
        ]);
        return "https://open.weixin.qq.com/connect/oauth2/authorize?$query#wechat_redirect";
    }

    /**
     * https://developers.weixin.qq.com/doc/offiaccount/OA_Web_Apps/JS-SDK.html#62
     * jsapi_ticket是公众号用于调用微信JS接口的临时票据
     */
    public function getJsApiTicket()
    {
        $api = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=" . $this->token;
        return $this->promise->get($api);
    }

    /**
     * https://developers.weixin.qq.com/doc/offiaccount/OA_Web_Apps/JS-SDK.html#62
     * $url = domain() . $_SERVER['REQUEST_URI'];
     */
    public function sdkSignPackage($url)
    {
        $jsapiTicket = $this->promise->get_jsapi_ticket();
        $nonceStr = substr(str_shuffle('qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM1234567890'), 0, 16);
        $timestamp = time();
        // 这里参数的顺序要按照 key 值 ASCII 码升序排序
        $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";
        return [
            "appId" => $this->promise->appid(),
            "signature" => sha1($string),
            "timestamp" => $timestamp,
            "nonceStr" => $nonceStr,
            "rawString" => $string,
            "url" => $url
        ];
    }

    /**
     * https://developers.weixin.qq.com/doc/offiaccount/OA_Web_Apps/Wechat_webpage_authorization.html#1
     * 通过code换取网页授权access_token
     * @param $code
     */
    public function code2token($code)
    {
        $query = [
            'appid' => $this->promise->appid(),
            'secret' => $this->promise->secret(),
            'code' => $code,
            'grant_type' => 'authorization_code',
        ];
        $api = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=' . http_build_query($query);
        $this->promise->get($api);
    }

    /**
     * https://developers.weixin.qq.com/doc/offiaccount/OA_Web_Apps/Wechat_webpage_authorization.html#3
     * 拉取用户信息(需scope为 snsapi_userinfo)
     * @param $access_token
     * @param $openid
     */
    public function token2info($access_token, $openid)
    {
        $this->promise->get("https://api.weixin.qq.com/sns/userinfo?access_token=$access_token&openid=$openid");
    }

    /**
     * https://developers.weixin.qq.com/doc/offiaccount/Account_Management/Generating_a_Parametric_QR_Code.html
     * 微信生成带参数的二维码
     * 永久二维码
     * 数字形式：{"action_name": "QR_LIMIT_SCENE", "action_info": {"scene": {"scene_id": 123}}}
     * 字符串形式：{"action_name": "QR_LIMIT_STR_SCENE", "action_info": {"scene": {"scene_str": "test"}}}
     * 通过ticket换取二维码
     * https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=TICKET
     * @param $scene
     * @param bool $int
     * @return mixed
     */
    public function wxQRCode($scene, $int = false)
    {
        if ($int) {
            $json = [
                'action_name' => 'QR_LIMIT_SCENE',
                'action_info' => [
                    'scene' => [
                        'scene_id' => intval($scene)
                    ]
                ],
            ];
        } else {
            $json = [
                'action_name' => 'QR_LIMIT_STR_SCENE',
                'action_info' => [
                    'scene' => [
                        'scene_str' => $scene
                    ]
                ],
            ];
        }
        $api = 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=' . $this->token;
        return $this->promise->post($api, json_encode($json));
    }

    /**
     * https://developers.weixin.qq.com/doc/offiaccount/User_Management/Get_users_basic_information_UnionID.html#UinonId
     * 获取关注了公众号的用户的信息
     * @param $openid
     * @return mixed
     */
    public function user_info($openid)
    {
        $query = [
            'access_token' => $this->token,
            'openid' => $openid,
            'lang' => 'zh_CN',
        ];
        $api = 'https://api.weixin.qq.com/cgi-bin/user/info?' . http_build_query($query);
        return $this->promise->get($api);
    }

    /**
     * https://developers.weixin.qq.com/doc/offiaccount/Custom_Menus/Querying_Custom_Menus.html
     * 查询菜单
     */
    public function menuInfo()
    {
        $api = 'https://api.weixin.qq.com/cgi-bin/get_current_selfmenu_info?access_token=' . $this->token;
        return $this->promise->get($api);
    }

    /**
     * 发送模板消息
     * @param $template_id
     * @param $data
     * [
     * 'first' => array('value' => '结算成功通知', 'color' => '#173177'),
     * 'keyword1' => array('value' => '9000元', 'color' => '#173177'),
     * 'keyword2' => array('value' => '结算11月-12月的收益', 'color' => '#173177'),
     * 'keyword3' => array('value' => '2019-02-26 22：58', 'color' => '#173177'),
     * 'remark' => array('value' => '点击查看具体详情（跳转到结算明细）', 'color' => '#173177'),
     * ]
     * @param $openid
     * @param null $to_url
     * @param string $topic
     * @return mixed
     */
    public function template($template_id, $data, $openid, $to_url = null, $topic = '#FF0000')
    {
        $json = ['touser' => $openid,
            'url' => $to_url,
            'data' => $data,
            'topcolor' => $topic,
            'template_id' => $template_id,
        ];
        $api = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=' . $this->token;
        return $this->promise->post($api, json_encode($json));
    }


    /**
     * https://developers.weixin.qq.com/doc/offiaccount/Message_Management/Service_Center_messages.html#7
     * 发送客服消息
     * @param $openid
     * @param $msg
     * @return mixed
     */
    public function serviceMsg($openid, $msg)
    {
        $json = [
            'touser' => $openid,
            'msgtype' => 'text',
            'text' => [
                'content' => $msg
            ]
        ];
        $api = 'https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=' . $this->token;
        return $this->promise->post($api, json_encode($json));
    }

}