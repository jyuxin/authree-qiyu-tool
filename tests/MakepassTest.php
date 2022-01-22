<?php
namespace tests;

use makepass\Utils;

class MakepassTest
{
    public function test()
    {
        $sn = Utils::make_sn();
        $pass = Utils::make_pass(10,[1,3]);

        echo $sn;
        echo $pass;
    }
}