<?php
namespace YOCLIB\Multiformats\Multibase;

class Base36{

    public static function decode(string $binary): string{
        $hex = BaseUtil::str_baseconvert(strtolower($binary),36,16);
        return hex2bin($hex);
    }

    public static function encode(string $data): string{
        $hex = bin2hex($data);
        return BaseUtil::str_baseconvert($hex,16,36);
    }

}