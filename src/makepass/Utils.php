<?php
namespace makepass;

class Utils
{
    /**
     * 生成唯一字符串
     * @return string
     */
    public static function make_sn()
    {
        return strtoupper(md5(uniqid(md5(microtime(true)), true)));
    }

    /**
     * 生成单个卡密
     * @param  array $item [生成类型组合]
     * @param  integer $length [密码长度]
     * @return [string]        [密码]
     */
    public static function make_pass($length = 18, $item = [1, 2, 3, 4])
    {
        // 构成元素
        $chars = ['0123456789', 'abcdefghijklmnopqrstuvwxyz', 'ABCDEFGHIJKLMNOPQRSTUVWXYZ', '!@#$%^&*'];
        $str   = '';
        foreach ($item as $key => $val) {
            $str .= $chars[$val - 1];
        }
        $code = self::make_str($str, $length);
        return $code;
    }

    /**
     * 随机生成单个字符串
     * @param  string $chars [生成元素集合]
     * @param  integer $length [密码长度]
     * @return [string]        [密码]
     */
    private static function make_str($chars = '', $length = 18)
    {
        static $code;
        $last = '';
        do {
            $last = $code;
            $code = '';
            for ($i = 0; $i < $length; $i++) {
                $code .= $chars[mt_rand(0, strlen($chars) - 1)];
            }
        } while (substr($code, 0, 1) === '0');
        return $code;
    }
}