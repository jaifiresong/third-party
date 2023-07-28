<?php


namespace Official\Support;


class Crypto
{
    /**
     * 加密数据解密，用于小程序获取用户电话号码
     */
    public static function decrypt($encryptedData, $iv, $sessionKey, &$data)
    {
        if (strlen($iv) != 24) {
            return 1;
        }
        if (strlen($sessionKey) != 24) {
            return 2;
        }
        $aesIV = base64_decode($iv);
        $aesKey = base64_decode($sessionKey);
        $aesCipher = base64_decode($encryptedData);
        //解密
        $plaintext = openssl_decrypt($aesCipher, "AES-128-CBC", $aesKey, 1, $aesIV);
        $data = json_decode($plaintext, true);
        return 0;
    }
}