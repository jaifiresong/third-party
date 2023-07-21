<?php

/**
 * 微信通讯加解密
 */

namespace ThirdParty\Security;


class Crypto
{
    private $key; // EncodingAESKey(消息加密密钥)
    private $iv;

    //$k 长度需大于16
    public function __construct($secret = '4eaa2fe9acde5162cb94ebe301528d62')
    {
        $this->key = base64_decode($secret . '=');
        $this->iv = substr($this->key, 0, 16);
    }

    public function encrypt($text, $corpid = '')
    {
        //拼接
        $text = $this->getRandomStr() . pack('N', strlen($text)) . $text . $corpid;
        //添加PKCS#7填充
        $text = $this->PKCS7Encode($text);
        //加密
        return openssl_encrypt($text, 'AES-256-CBC', $this->key, OPENSSL_ZERO_PADDING, $this->iv);
    }

    public function decrypt($encrypted, &$from_corpid = null)
    {
        $decrypted = openssl_decrypt($encrypted, 'AES-256-CBC', $this->key, OPENSSL_ZERO_PADDING, $this->iv);
        //删除PKCS#7填充
        $result = $this->PKCS7Decode($decrypted);
        //拆分
        $content = substr($result, 16, strlen($result));
        $len_list = unpack('N', substr($content, 0, 4));
        $xml_len = $len_list[1];
        $xml_content = substr($content, 4, $xml_len);
        $from_corpid = substr($content, $xml_len + 4); //平台ID
        return $xml_content;
    }

    private function getRandomStr()
    {
        $str = '';
        $str_pol = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';
        $max = strlen($str_pol) - 1;
        for ($i = 0; $i < 16; $i++) {
            $str .= $str_pol[mt_rand(0, $max)];
        }
        return $str;
    }

    /**
     * 对需要加密的明文进行填充补位
     *
     * @param string $text 需要进行填充补位操作的明文
     * @return string 补齐明文字符串
     */
    private function PKCS7Encode($text)
    {
        $block_size = 32;
        $text_length = strlen($text);
        //计算需要填充的位数
        $amount_to_pad = $block_size - ($text_length % $block_size);
        if ($amount_to_pad == 0) {
            $amount_to_pad = $block_size;
        }
        //获得补位所用的字符
        $pad_chr = chr($amount_to_pad);
        $tmp = "";
        for ($index = 0; $index < $amount_to_pad; $index++) {
            $tmp .= $pad_chr;
        }
        return $text . $tmp;
    }

    /**
     * 对解密后的明文进行补位删除
     *
     * @param string $text 解密后的明文
     * @return string 删除填充补位后的明文
     */
    private function PKCS7Decode($text)
    {
        $block_size = 32;
        $pad = ord(substr($text, -1));
        if ($pad < 1 || $pad > $block_size) {
            $pad = 0;
        }
        return substr($text, 0, (strlen($text) - $pad));
    }
}
