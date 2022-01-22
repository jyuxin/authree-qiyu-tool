<?php
namespace encrypt\aes256cbc;

class Aes
{
    const METHOD = 'aes-256-cbc';

    private $key;

    private $iv;

    public function __construct($key, $iv)
    {
        $this->key = $key;
        $this->iv = $iv;
    }

    public function encrypt($data)
    {
        return openssl_encrypt(
            $data,
            self::METHOD,
            $this->getBytesFromString($this->key, 32),
            OPENSSL_RAW_DATA,
            $this->getBytesFromString($this->iv, 16)
        );
    }

    public function decrypt($data)
    {
        $openssl_output = openssl_decrypt(
            $data,
            self::METHOD,
            $this->getBytesFromString($this->key, 32),
            OPENSSL_RAW_DATA,
            $this->getBytesFromString($this->iv, 16)
        );

        if ($openssl_output !== false) {
            return $openssl_output;
        }

        return openssl_error_string();
    }

    private function getBytesFromString($string, $size) {
        return mb_substr($string, 0, $size);
    }
}
