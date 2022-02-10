<?php
namespace authree\qiyu\encrypt\rsa256;

/**
 * RSA 公钥 私钥加密 解密
 */
class Rsa
{

    private $_config;

    public function __construct($conf)
    {
        $rsa_config = array();
        $rsa_config['private_key'] = $this->_getFilekey($conf['private_key_path']);
        $rsa_config['public_key']  = $this->_getFilekey($conf['public_key_path']);
        $this->_config = $rsa_config;
    }

    /**
     * 私钥加密
     * @param string $data 要加密的数据
     * @return string 加密后的字符串
     */
    public function privateKeyEncode($data)
    {
        $encryptData = '';
        $private_key = openssl_pkey_get_private($this->_config['private_key']);
        $crypto = '';
        // 1024位加密密钥使用117分段加密，128分段解密
        // 2048位加密密钥使用245分段加密，256分段解密
        foreach (str_split($data, 245) as $chunk) {
            openssl_private_encrypt($chunk, $encryptData, $private_key);
            $crypto .= $encryptData;
        }
        return base64_encode($crypto);
    }

    /**
     * 公钥加密
     * @param string $data 要加密的数据
     * @return string 加密后的字符串
     */
    public function publicKeyEncode($data)
    {
        $encrypted = '';
        $public_key = openssl_pkey_get_public($this->_config['public_key']);
        $crypto = '';
        foreach (str_split($data, 245) as $chunk) {
            openssl_public_encrypt($chunk, $encrypted, $public_key); //公钥加密
            $crypto = $crypto.$encrypted;
        }
        return base64_encode($crypto);
    }

    /**
     * 用公钥解密私钥加密内容
     * @param string $data 要解密的数据
     * @return string 解密后的字符串
     */
    public function decodePrivateEncode($data)
    {
        $crypto = '';
        $datas = base64_decode($data);
        $public_key = openssl_pkey_get_public($this->_config['public_key']);
        foreach (str_split($datas, 256) as $chunk) {
            openssl_public_decrypt($chunk, $decryptData, $public_key);
            $crypto .= $decryptData;
        }
        return $crypto;
    }

    /**
     * 用私钥解密公钥加密内容 
     * @param string $data  要解密的数据
     * @return string 解密后的字符串
     */
    public function decodePublicEncode($data)
    {
        $crypto = '';
        $datas = base64_decode($data);
        $private_key = openssl_pkey_get_private($this->_config['private_key']);
        foreach (str_split($datas, 256) as $chunk) {
            openssl_private_decrypt($chunk, $decryptData, $private_key);
            $crypto .= $decryptData;
        }
        return $crypto;
    }

    /**
     * 获取秘钥文件内容
     */
    private function _getFilekey($data)
    {
        if (!file_exists($data)) {
            throw new \Exception('秘钥文件不存在');
        }
        $key_data = file_get_contents($data);
        if (empty($key_data)) {
            throw new \Exception('秘钥为空');
        }
        return $key_data;
    }
}
