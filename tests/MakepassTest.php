<?php
namespace authree\qiyu\tests;

use authree\qiyu\makepass\Utils;

class MakepassTest
{
    public function test()
    {
        $sn = Utils::make_sn();
        $pass = Utils::make_pass(10,[1,3]);

//        Utils::utf8_strlen('123大师傅');
//        Utils::string_to_array('123大师傅');
//        Utils::xml_to_array("<note><to>George</to><from>John</from></note>");

        echo $sn;
        echo $pass;
    }
}