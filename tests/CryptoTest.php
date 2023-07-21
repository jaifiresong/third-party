<?php


namespace Test;


use PHPUnit\Framework\TestCase;
use ThirdParty\Security\Crypto;

class CryptoTest extends TestCase
{

    public function testEncrypt()
    {
        $t = new Crypto();
        $r = $t->encrypt('abcd1234.');
        var_dump($r);
        $this->assertIsString($r);
    }

    public function testDecrypt()
    {
        $t = new Crypto();
        $ciphertext = $t->encrypt('abcd1234.');
        var_dump($ciphertext);
        $plaintext = $t->decrypt($ciphertext);
        var_dump($plaintext);
        $this->assertEquals($plaintext, 'abcd1234.');
    }
}