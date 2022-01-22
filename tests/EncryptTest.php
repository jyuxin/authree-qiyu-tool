<?php
namespace tests;

use encrypt\aes256cbc\Aes;
use encrypt\rsa256\Rsa;

class EncryptTest
{
    public function aes()
    {
        $key = '';
        $iv = '';

        $textStr = '123456';

        $obj = new Aes($key,$iv);

        $pass = $obj->encrypt($textStr); // 加密

        $text = $obj->decrypt($textStr); // 解密

        echo $pass; // 密文
        echo $text; // 明文
    }

    public function rsa()
    {
        $conf = [
            'private_key_path' => '/xx/xx/xx/private_key.pem',
            'public_key_path' => '/xx/xx/xx/public_key.pem',
        ];

        $textStr = '123456';

        $obj = new Rsa($conf);

        $pass = $obj->privateKeyEncode($textStr); // 私钥加密

        $text = $obj->decodePrivateEncode($textStr); // 公钥解密

        echo $pass; // 密文
        echo $text; // 明文

        $pass = $obj->publicKeyEncode($textStr); // 公钥加密
        $text = $obj->decodePublicEncode($textStr); // 私钥解密

        echo $pass; // 密文
        echo $text; // 明文
    }
}