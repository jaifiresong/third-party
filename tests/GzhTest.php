<?php


namespace Test;


use Official\Gzh;
use PHPUnit\Framework\TestCase;
use Test\Feeds\GzhConfig;

class GzhTest extends TestCase
{
    public function test1()
    {
        $r = Gzh::material(new GzhConfig(''))->addMaterial('image', __DIR__ . '/1.png');
        var_dump($r);
        //{"media_id":"syAL6A7PipSNiY2a3zbRROX-CXyJoY_armWgAnSLODjiiVax6xdtLSSfmiZ6BDoM","url":"http:\/\/mmbiz.qpic.cn\/sz_mmbiz_png\/5Z0gFDBgy254krrWwDhJicayEx0GrrMGwnRqxZicaGD0EQUSKyQHQn3IAsWfh2Z2IupM5Gecst68p0eAhica3icWNQ\/0?wx_fmt=png","item":[]}
        $this->assertIsString("");
    }

    public function test2()
    {
        $r = Gzh::material(new GzhConfig(''))->batchGetMaterial('image', 0);
        var_dump($r);
        $this->assertIsString("");
    }
}