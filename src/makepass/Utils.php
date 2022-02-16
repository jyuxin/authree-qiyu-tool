<?php
namespace authree\qiyu\makepass;

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

    /**
     * 汉字长度为1 计算字符串长度
     * @param null $string
     * @return int
     */
    public static function utf8_strlen($string = '')
    {
        if(empty($string)){
            return 0;
        }

        // 将字符串分解为单元
        preg_match_all("/./us", $string, $match);

        // 返回单元个数
        return count($match[0]);
    }

    /**
     * 字符串转数组、支持中文（只能是utf-8）
     * @param $str
     * @return array
     */
    public static function string_to_array($str='')
    {
        if(empty($str)){
            return [];
        }

        $result = array();
        $len = strlen($str);
        $i = 0;
        while($i < $len){
            $chr = ord($str[$i]);
            if($chr == 9 || $chr == 10 || (32 <= $chr && $chr <= 126)) {
                $result[] = substr($str,$i,1);
                $i +=1;
            }elseif(192 <= $chr && $chr <= 223){
                $result[] = substr($str,$i,2);
                $i +=2;
            }elseif(224 <= $chr && $chr <= 239){
                $result[] = substr($str,$i,3);
                $i +=3;
            }elseif(240 <= $chr && $chr <= 247){
                $result[] = substr($str,$i,4);
                $i +=4;
            }elseif(248 <= $chr && $chr <= 251){
                $result[] = substr($str,$i,5);
                $i +=5;
            }elseif(252 <= $chr && $chr <= 253){
                $result[] = substr($str,$i,6);
                $i +=6;
            }
        }

        return $result;
    }

    /**
     * xml数据解析成数组
     * @param $xml
     * @return false|mixed
     */
    public static function xml_to_array($xml='')
    {
        $xml_parser = xml_parser_create();
        if( !xml_parse($xml_parser,$xml,true) ){
            xml_parser_free($xml_parser);

            return false;
        }else {
            $array_data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);

            return $array_data;
        }
    }

}