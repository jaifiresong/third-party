<?php


namespace Test;


use PHPUnit\Framework\TestCase;
use ReqTencent\Weixin\Official\Gzh;
use ReqTencent\Weixin\Official\Support\Common;
use Test\Feeds\GzhConfig;


class GzhTest extends TestCase
{
    public function test01()
    {
        $r = Gzh::material(new GzhConfig(''))->addMaterial('image', __DIR__ . '/111');
        var_dump($r);
        //{"media_id":"syAL6A7PipSNiY2a3zbRROX-CXyJoY_armWgAnSLODjiiVax6xdtLSSfmiZ6BDoM","url":"http:\/\/mmbiz.qpic.cn\/sz_mmbiz_png\/5Z0gFDBgy254krrWwDhJicayEx0GrrMGwnRqxZicaGD0EQUSKyQHQn3IAsWfh2Z2IupM5Gecst68p0eAhica3icWNQ\/0?wx_fmt=png","item":[]}
        $this->assertIsString($r);
    }

    public function test02()
    {
        $r = Gzh::material(new GzhConfig(''))->batchGetMaterial('image', 0);
        var_dump($r);
        $this->assertIsString($r);
    }

    public function test03()
    {
        $r = Gzh::base(new GzhConfig(''))->oauth2Authorize(2, '');
        var_dump($r);
        $this->assertIsString($r);
    }
}