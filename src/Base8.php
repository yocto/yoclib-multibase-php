<?php
namespace YOCLIB\Multiformats\Multibase;

class Base8{

    public static function decode(string $octal): string{
        $hex = BaseUtil::str_baseconvert($octal,8,16);
        while(strlen($hex)%2!==0){
            $hex = '0'.$hex;
        }
        $binary = hex2bin($hex);
        for($i=0;$i<strlen($binary);$i++){
            $binary[$i] = chr(ord($binary[$i])/2);
        }
        return $binary;
    }

    public static function encode(string $data): string{
        for($i=0;$i<strlen($data);$i++){
            $data[$i] = chr(ord($data[$i])*2);
        }
        $hex = bin2hex($data);
        return BaseUtil::str_baseconvert($hex,16,8);
    }

}