<?php
namespace authree\qiyu\encrypt\aes;

class Aes
{
    private $method;
    private $key;

    public function __construct($key, $method = 'AES-128-ECB')
    {
        $this->method = $method;
        $this->key = $key;
    }


    public function encrypt($string)
    {
        // 对接java的AES加密通过SHA1PRNG算法
        $key = substr(openssl_digest(openssl_digest($this->key, 'sha1', true), 'sha1', true), 0, 16);

        // openssl_encrypt 加密不同Mcrypt，对秘钥长度要求，超出16加密结果不变
        $data = openssl_encrypt($string, $this->method, $key, OPENSSL_RAW_DATA);

        $data = strtolower(bin2hex($data));

        return $data;
    }

    public function decrypt($string)
    {
        // 对接java的AES加密通过SHA1PRNG算法
        $key = substr(openssl_digest(openssl_digest($this->key, 'sha1', true), 'sha1', true), 0, 16);

        $decrypted = openssl_decrypt(hex2bin($string), $this->method, $key, OPENSSL_RAW_DATA);

        return $decrypted;
    }
}
