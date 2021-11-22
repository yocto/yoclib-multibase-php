<?php
namespace YOCLIB\Multiformats\Multibase;

use InvalidArgumentException;

class Multibase{

    public const IDENTITY = "\0";
    public const BASE2 = '0';
    /*DRAFT*/public const BASE8 = '7';
    /*DRAFT*/public const BASE10 = '9';
    public const BASE16 = 'f';
    public const BASE16UPPER = 'F';
    public const BASE32HEX = 'v';
    public const BASE32HEXUPPER = 'V';
    public const BASE32HEXPAD = 't';
    public const BASE32HEXPADUPPER = 'T';
    public const BASE32 = 'b';
    public const BASE32UPPER = 'B';
    public const BASE32PAD = 'c';
    public const BASE32PADUPPER = 'C';
    /*DRAFT*/public const BASE32Z = 'h';
    /*DRAFT*/public const BASE36 = 'k';
    /*DRAFT*/public const BASE36UPPER = 'K';
    public const BASE58BTC = 'z';
    public const BASE58FLICKR = 'Z';
    public const BASE64 = 'm';
    public const BASE64PAD = 'M';
    public const BASE64URL = 'u';
    public const BASE64URLPAD = 'U';
    /*DRAFT*/public const PROQUINT = 'p';

    private const ALPHABET32 = 'abcdefghijklmnopqrstuvwxyz234567=';
    private const ALPHABET32_HEX = '0123456789abcdefghijklmnopqrstuv=';
    private const ALPHABET32_ZOOKO = 'ybndrfg8ejkmcpqxot1uwisza345h769=';

    private const ALPHABET58_BITCOIN = '123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz';
    private const ALPHABET58_FLICKR = '123456789abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ';

    public static function decode(string $data): string{
        $b = substr($data,0,1);
        $rest = substr($data,1);
        switch($b){
            case self::IDENTITY:{
                return $rest;
            }
            case self::BASE2:{
                return Base2::decode($rest);
            }
            case self::BASE8:{
                return Base8::decode($rest);
            }
            case self::BASE10:{
                return Base10::decode($rest);
            }
            case self::BASE16:{
                return Base16::decode($rest);
            }
            case self::BASE16UPPER:{
                return Base16::decode(strtolower($rest));
            }
            case self::BASE32HEX:
            case self::BASE32HEXPAD:{
                return Base32::decode($rest,self::ALPHABET32_HEX);
            }
            case self::BASE32HEXUPPER:
            case self::BASE32HEXPADUPPER:{
                return Base32::decode(strtolower($rest),self::ALPHABET32_HEX);
            }
            case self::BASE32:
            case self::BASE32PAD:{
                return Base32::decode($rest,self::ALPHABET32);
            }
            case self::BASE32UPPER:
            case self::BASE32PADUPPER:{
                return Base32::decode(strtolower($rest),self::ALPHABET32);
            }
            case self::BASE32Z:{
                return Base32::decode($rest,self::ALPHABET32_ZOOKO);
            }
            case self::BASE36:{
                return Base36::decode($rest);
            }
            case self::BASE36UPPER:{
                return Base36::decode(strtolower($rest));
            }
            case self::BASE58BTC:{
                return Base58::decode($rest,self::ALPHABET58_BITCOIN);
            }
            case self::BASE58FLICKR:{
                return Base58::decode($rest,self::ALPHABET58_FLICKR);
            }
            case self::BASE64:
            case self::BASE64PAD:{
                return Base64::decode($rest);
            }
            case self::BASE64URL:
            case self::BASE64URLPAD:{
                return Base64::decode(str_replace(['-','_'],['+','/'],$rest));
            }
            default:{
                throw new InvalidArgumentException('Unsupported base decoding: '.$b);
            }
        }
    }

    public static function encode(string $b,string $data){
        switch($b){
            case self::IDENTITY:{
                return $b.$data;
            }
            case self::BASE2:{
                return $b.Base2::encode($data);
            }
            case self::BASE8:{
                return $b.Base8::encode($data);
            }
            case self::BASE10:{
                return $b.Base10::encode($data);
            }
            case self::BASE16:{
                return $b.Base16::encode($data);
            }
            case self::BASE16UPPER:{
                return $b.strtoupper(Base16::encode($data));
            }
            case self::BASE32HEX:{
                return $b.str_replace('=','',Base32::encode($data,self::ALPHABET32_HEX));
            }
            case self::BASE32HEXUPPER:{
                return $b.str_replace('=','',strtoupper(Base32::encode($data,self::ALPHABET32_HEX)));
            }
            case self::BASE32HEXPAD:{
                return $b.Base32::encode($data,self::ALPHABET32_HEX);
            }
            case self::BASE32HEXPADUPPER:{
                return $b.strtoupper(Base32::encode($data,self::ALPHABET32_HEX));
            }
            case self::BASE32:{
                return $b.str_replace('=','',Base32::encode($data,self::ALPHABET32));
            }
            case self::BASE32UPPER:{
                return $b.str_replace('=','',strtoupper(Base32::encode($data,self::ALPHABET32)));
            }
            case self::BASE32PAD:{
                return $b.Base32::encode($data,self::ALPHABET32);
            }
            case self::BASE32PADUPPER:{
                return $b.strtoupper(Base32::encode($data,self::ALPHABET32));
            }
            case self::BASE32Z:{
                return $b.str_replace('=','',Base32::encode($data,self::ALPHABET32_ZOOKO));
            }
            case self::BASE36:{
                return $b.Base36::encode($data);
            }
            case self::BASE36UPPER:{
                return $b.strtoupper(Base36::encode($data));
            }
            case self::BASE58BTC:{
                return $b.Base58::encode($data,self::ALPHABET58_BITCOIN);
            }
            case self::BASE58FLICKR:{
                return $b.Base58::encode($data,self::ALPHABET58_FLICKR);
            }
            case self::BASE64:{
                return $b.str_replace('=','',Base64::encode($data));
            }
            case self::BASE64PAD:{
                return $b.Base64::encode($data);
            }
            case self::BASE64URL:{
                return $b.str_replace('=','',str_replace(['+','/'],['-','_'],Base64::encode($data)));
            }
            case self::BASE64URLPAD:{
                return $b.str_replace(['+','/'],['-','_'],Base64::encode($data));
            }
            default:{
                throw new InvalidArgumentException('Unsupported base encoding: '.$b);
            }
        }
    }

}