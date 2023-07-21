<?php


namespace Test;


use PHPUnit\Framework\TestCase;
use ThirdParty\Support\Decipher;

class TestDecipher extends TestCase
{

    public function test01()
    {
        //authorized
        $xml = "<xml>     <AppId><![CDATA[wxbe7c3deadc2edad4]]></AppId>     <Encrypt><![CDATA[MtzxrDp7NQS6lUTmM1gb6DBrWDP4TFReAsKPGlXqPhbnRVZurisTiXTJt5/j9vsfQeshX0Uv4t4UBbDsdEQZXRMl70+zSJjFH2HOqS3LpWmv3RqoRIO3GQGykYmTCs6Yw7mlwklpzZ8CqaP6Y+3k1o5E23JzfMOdZ8PInHbdtw/46PniFAmGOI2rSgPEj5U60PEsWibsLB7VJov92+7D8qNT5bCk7sggUcvREAEMpMnhWx4W2Dd7NWu1CqUJoshQSz6eyTBQ+K+GoWWUakXAIiSk0ApLPZ2GBJFf6NjM1GxM9cHGel6B4GsIIFklyI3KzsjmchrPyMwW9uWsXhOeuQvYCBK0t1AlHszCwCxB+qywOtRLCAeg5UE4rOggxm4L1APV45wuXJVnAPvhJPH6t2ypOOQOXVUuT6osdrYPVmMz4C2AfUPbV/lw8add0P/QqrodAOPGw5kPcR/uhxEZEbV196Vrld7mMl7ifmlRplj/aWNwEGMFk6b+OrX4nErwmP/NP5rQ2bchSIna5T1etW0fO0O5epurC0cSqJqG88LQIuxEucJDgqrR/QHz9NyGzW6XxD3gUlqHo3l78/DB6VEqqw3YhTUjLDwLvLv7qL2vAMdJgzSRdZqi+oeSSsyzNaNRjzeMEKi77RW9tb2xhUFA0iPPxBsNRI/5SEh6kPRq0DMsNqjZz+uWqeAQKzT6/obhBvf0Haeq6C26s8QkOC3lqF3zsOCrO3pujbtLyUJ59PB6rK6Z18DQJCBjOkYtkEW1ZpVJTQpv+FpyghWvhZzOqd54Ni3UGaM9QGju/Jwuif7empxbvdb8akTVbRveihkhRFhVvWmCE+r9u5+ztA==]]></Encrypt> </xml>";
        $get = json_decode('{"signature":"1c5671158d3b07b6634629d8eae1d1776a6af125","timestamp":"1689055850","nonce":"264481994","encrypt_type":"aes","msg_signature":"830020c95135e836a7ecaa0910d3b381e47d7b5f"}', true);
        $t = new Decipher('lksdfklsadflasdfklsdkfsdkdkdkdksdafkjsadfkd', 's1VAQKWGzanrdtD3', 'wxbe7c3deadc2edad4');
        $r = $t->decryptMsg($get['msg_signature'], $get['timestamp'], $get['nonce'], $xml);
        var_dump($r);
        $this->assertIsArray($r);
    }

    public function test02()
    {
        // component_verify_ticket
        $xml = "<xml>     <AppId><![CDATA[wxbe7c3deadc2edad4]]></AppId>     <Encrypt><![CDATA[rtkCtaBYoEie6Kn2AGrcNHVJvqpb6zqhBT1hs1zbQreXL1SzTkdqBspWGqrwMN3zDKo0fb7i8SXah9FiwZBI0fTHp4P3Wqsg0Mi9R1OCbQZ7ukk54KnYC5RJZyJuwJU53ZbXXKNAPYabWJh6rvYPKaMk/TV3R1W1s8njhGcWLR6qfmwxHtxO+W5FbhZttX9/zvTYLa3hGzYhttMxL4r3ELBhyW7TwZXxASBgtegkOABe/jUuvG0qA0eoqQZeAk+cJs8GIz+hhzdf++74g26FRMwU3nLHgSFxmpIi78AsfA/6LbEZSlq02l9ZdjMfUNYcOmiO6s6gMd8QKv50tEG/lIfYw/LmMYf3VICjMuPwqpPZRk1zqRmn0g8cVS1V+KkuI2uw9BXBSKMfTtTHNkommNLYqpAXL7VpOQ+H7c2Bd6V0RoYFokxES199OyUo97uPquRNBPfpU+Io1tT9pNtJTA==]]></Encrypt> </xml>";
        $get = json_decode('{"signature":"d1d34922f4f4730248a6163b6dce46d8ab2d634c","timestamp":"1689652019","nonce":"539172486","encrypt_type":"aes","msg_signature":"56f21aa2e3cc527d077fabbbec2114dec1e8d982"}', true);
        $t = new Decipher('lksdfklsadflasdfklsdkfsdkdkdkdksdafkjsadfkd', 's1VAQKWGzanrdtD3', 'wxbe7c3deadc2edad4');
        $r = $t->decryptMsg($get['msg_signature'], $get['timestamp'], $get['nonce'], $xml);
        var_dump($r);
        $this->assertIsArray($r);
    }
}