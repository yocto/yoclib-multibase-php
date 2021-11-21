<?php
namespace YOCLIB\Multiformats\Multibase;

class Base64{

    public static function decode(string $base64): string{
        return base64_decode($base64);
    }

    public static function encode(string $data): string{
        return base64_encode($data);
    }

}