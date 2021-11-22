<?php
namespace YOCLIB\Multiformats\Multibase;

class Base16{

    public static function decode(string $hex): string{
        return hex2bin($hex);
    }

    public static function encode(string $data): string{
        return bin2hex($data);
    }

}