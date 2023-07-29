<?php

namespace ReqTencent\Weixin\Official\Api\Xcx;

use ReqTencent\Weixin\Official\Contracts\XcxApiInterface;

class Base
{
    private $token;
    private $promise;

    public function __construct(XcxApiInterface $promise)
    {
        $this->token = $promise->get_access_token();
        $this->promise = $promise;
    }

    /**
     * https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/login/auth.code2Session.html
     * 通过 wx.login 接口获得临时登录凭证 code
     */
    public function code2Session($code)
    {
        $appid = $this->promise->appid();
        $secret = $this->promise->secret();
        $api = "https://api.weixin.qq.com/sns/jscode2session?appid=$appid&secret=$secret&js_code=$code&grant_type=authorization_code";
        return $this->promise->get($api);
    }

    /**
     * 异步校验图片/音频是否含有违法违规内容。
     * @return mixed {"errcode":0,"errmsg":"ok","trace_id":"62abe636-76ef39f0-61cfa62d"}
     */
    public function mediaCheckAsync($openid, $media_url)
    {
        $json = [
            'version' => 2,  //2.0版本为固定值2
            'scene' => 2,
            'media_type' => 2, //1:音频;2:图片
            'openid' => $openid,
            'media_url' => $media_url,
        ];
        $api = 'https://api.weixin.qq.com/wxa/media_check_async?access_token=' . $this->token;
        //httpPost
        return $this->promise->post($api, $json);
    }

    /**
     * 检查一段文本是否含有违法违规内容。
     * @return mixed {"errcode":0,"errmsg":"ok","detail":[{"strategy":"keyword","errcode":0},{"strategy":"content_model","errcode":0,"suggest":"pass","label":100,"prob":90}],"trace_id":"62abe43a-79672562-2c96f8c7","result":{"suggest":"pass","label":100}}null
     */
    public function msgCheck($openid, $content)
    {
        $json = [
            'version' => 2,
            'openid' => $openid,
            'scene' => 2,
            'content' => $content, //需检测的文本内容，文本字数的上限为2500字，需使用UTF-8编码
        ];
        $api = 'https://api.weixin.qq.com/wxa/msg_sec_check?access_token=' . $this->token;
        //httpPost
        return $this->promise->post($api, $json);
    }

    /**
     * https://developers.weixin.qq.com/miniprogram/dev/OpenApiDoc/mp-message-management/subscribe-message/sendMessage.html
     * 发送订阅消息
     * $msg = [
     *      'thing2' => ["value" => '恭喜您！照片审核已通过！'],
     *      'thing3' => ["value" => '【点这里】立刻申领黑盖！做黑盖品鉴官！'],
     * ]
     */
    public function sendSubMsg($touser, $template_id, $msg, $page = 'pages/index/index')
    {
        $json = [
            "touser" => $touser,
            "template_id" => $template_id,
            "page" => $page,
            "data" => $msg,
            "miniprogram_state" => "formal", // 跳转小程序类型：developer为开发版；trial为体验版；formal为正式版；默认为正式版
            "lang" => "zh_CN",
        ];
        $api = 'https://api.weixin.qq.com/cgi-bin/message/subscribe/send?access_token=' . $this->token;
        //httpPost
        return $this->promise->post($api, $json);
    }


    /**
     * https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/url-scheme/urlscheme.generate.html#method-http
     * 获取小程序 scheme 码，适用于短信、邮件、外部网页、微信内等拉起小程序的业务场景。目前仅针对国内非个人主体的小程序开放
     */
    public function urlscheme($query = '', $env = 'release')
    {
        $json = [
            'jump_wxa' => [
                'path' => 'pages/loading1/index',
                'query' => $query,
                'env_version' => $env,//正式版为"release"，体验版为"trial"，开发版为"develop"，仅在微信外打开时生效。
            ],
            'expire_type' => 1,//失效类型，失效时间：0，失效间隔天数：1
            'expire_interval' => 30,
        ];
        $api = 'https://api.weixin.qq.com/wxa/generatescheme?access_token=' . $this->token;
        //httpPost
        return $this->promise->post($api, $json);
    }


    /**
     * https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/qr-code/wxacode.getUnlimited.html
     * 获取小程序码，永久有效，数量暂无限制
     * @param string $path 扫码进入的小程序页面路径
     * @return mixed 如果调用成功，会直接返回图片二进制内容，如果请求失败，会返回 JSON 格式的数据。
     */
    public function getWxaCodeUnlimit($scene, $page)
    {
        $json = [
            'scene' => $scene, //最大32个可见字符，只支持数字，大小写英文以及部分特殊字符：!#$&'()*+,/:;=?@-._~
            'page' => $page, //页面 page，例如 pages/index/index，根路径前不要填加 /，不能携带参数（参数请放在 scene 字段里），如果不填写这个字段，默认跳主页面
            'env_version' => 'release', // 要打开的小程序版本。正式版为 release，体验版为 trial，开发版为 develop
            'width' => 430, //二维码的宽度，单位 px，最小 280px，最大 1280px
            'auto_color' => false, //自动配置线条颜色，如果颜色依然是黑色，则说明不建议配置主色调
        ];
        $api = "https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token=" . $this->token;
        //httpPost
        //header('Content-type:image/jpeg');
        return $this->promise->post($api, $json);
    }


    /**
     * https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/qr-code/wxacode.get.html
     * 获取小程序码，永久有效，有数量限制，共生成的码数量限制为 100,000，参数一样的就只算一次，和接口请求次数没有关系。
     * @param string $path 扫码进入的小程序页面路径
     * @return mixed 如果调用成功，会直接返回图片二进制内容，如果请求失败，会返回 JSON 格式的数据。
     */
    public function getWxaCode($path)
    {
        $json = [
            'path' => $path, //扫码进入的小程序页面路径，最大长度 128 字节；可带参数，如：传入 "?foo=bar"，即可在 wx.getLaunchOptionsSync 接口中的 query 参数获取到 {foo:"bar"}。
            'env_version' => 'release', //要打开的小程序版本。正式版为 release，体验版为 trial，开发版为 develop
            'width' => 430, //二维码的宽度，单位 px。最小 280px，最大 1280px
            'auto_color' => false, //自动配置线条颜色，如果颜色依然是黑色，则说明不建议配置主色调
        ];
        $api = "https://api.weixin.qq.com/wxa/getwxacode?access_token=" . $this->token;
        //httpPost
        //header('Content-type:image/jpeg');
        return $this->promise->post($api, $json);
    }
}