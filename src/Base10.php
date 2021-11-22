<?php
namespace YOCLIB\Multiformats\Multibase;

class Base10{

    public static function decode(string $decimal): string{
        $hex = BaseUtil::str_baseconvert($decimal,10,16);
        while(strlen($hex)%2!==0){
            $hex = '0'.$hex;
        }
        return hex2bin($hex);
    }

    public static function encode(string $data): string{
        $hex = bin2hex($data);
        return BaseUtil::str_baseconvert($hex,16,10);
    }

}