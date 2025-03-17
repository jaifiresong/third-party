<?php


namespace ReqTencent\Weixin\Official\Api\Gzh;

use ReqTencent\Weixin\Official\Contracts\GzhApiInterface;

class Draft
{
    private $token;
    private $promise;

    public function __construct(GzhApiInterface $promise)
    {
        $this->token = $promise->get_access_token();
        $this->promise = $promise;
    }

    /**
     * https://developers.weixin.qq.com/doc/offiaccount/Draft_Box/Add_draft.html
     */
    public function add($data)
    {
        $json = $data;
        $api  = 'https://api.weixin.qq.com/cgi-bin/draft/add?access_token=' . $this->token;
        return $this->promise->post($api, json_encode($json,JSON_UNESCAPED_UNICODE));
    }
}
