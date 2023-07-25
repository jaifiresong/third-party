<?php


namespace ThirdParty\Promise;


interface CurlPromise
{
    /**
     * post 请求
     */
    public function post($url, $params);

    /**
     * 获取预授权码的请求
     */
    public function preAuthCodePost($api, $params);
}