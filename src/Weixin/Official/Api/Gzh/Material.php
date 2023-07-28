<?php


namespace Official\Api\Gzh;

use Official\Contracts\GzhApiInterface;

class Material
{
    private $token;
    private $promise;

    public function __construct(GzhApiInterface $promise)
    {
        $this->token = $promise->get_access_token();
        $this->promise = $promise;
    }

    /**
     * https://developers.weixin.qq.com/doc/offiaccount/Asset_Management/Adding_Permanent_Assets.html
     * 新增永久素材
     * 媒体文件类型，分别有图片（image）、语音（voice）、视频（video）和缩略图（thumb）
     * -F media=@media.file -F description='{"title":VIDEO_TITLE, "introduction":INTRODUCTION}
     * @param $type
     * @param $file_path
     * @param array $description
     * @return mixed
     */
    public function addMaterial($type, $file_path, array $description = [])
    {
        $payload = [
            "media" => curl_file_create($file_path),
            "description" => json_encode($description),
        ];
        $api = "https://api.weixin.qq.com/cgi-bin/material/add_material?access_token={$this->token}&type=$type";
        return $this->promise->post($api, $payload);
    }

    /**
     * https://developers.weixin.qq.com/doc/offiaccount/Asset_Management/Getting_Permanent_Assets.html
     * 根据media_id通过本接口下载永久素材，临时素材无法通过本接口获取
     * @param $media_id
     * @return mixed
     */
    public function getMaterial($media_id)
    {
        $json = ['media_id' => $media_id];
        $api = 'https://api.weixin.qq.com/cgi-bin/material/get_material?access_token=' . $this->token;
        return $this->promise->post($api, json_encode($json));
    }

    /**
     * https://developers.weixin.qq.com/doc/offiaccount/Asset_Management/Get_materials_list.html
     * 媒体文件类型，分别有图片（image）、语音（voice）、视频（video）和缩略图（thumb）
     */
    public function batchGetMaterial($type, $offset)
    {
        $json = [
            'type' => $type,
            'offset' => $offset,//0表示从第一个素材
            'count' => 20,
        ];
        $api = 'https://api.weixin.qq.com/cgi-bin/material/batchget_material?access_token=' . $this->token;
        return $this->promise->post($api, json_encode($json));
    }
}