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

    /**
     * @param string $data
     * @param string|null $code
     * @return string
     */
    public static function decode(string $data,?string $code=null): string{
        $decoded = null;
        if($code==null){
            $code = substr($data,0,1);
            $data = substr($data,1);
        }
        switch($code){
            case self::IDENTITY:{
                $decoded = $data;
                break;
            }
            case self::BASE2:{
                $decoded = Base2::decode($data);
                break;
            }
            case self::BASE8:{
                $decoded = Base8::decode($data);
                break;
            }
            case self::BASE10:{
                $decoded = Base10::decode($data);
                break;
            }
            case self::BASE16:{
                $decoded = Base16::decode($data);
                break;
            }
            case self::BASE16UPPER:{
                $decoded = Base16::decode(strtolower($data));
                break;
            }
            case self::BASE32HEX:
            case self::BASE32HEXPAD:{
                $decoded = Base32::decode($data,self::ALPHABET32_HEX);
                break;
            }
            case self::BASE32HEXUPPER:
            case self::BASE32HEXPADUPPER:{
                $decoded = Base32::decode(strtolower($data),self::ALPHABET32_HEX);
                break;
            }
            case self::BASE32:
            case self::BASE32PAD:{
                $decoded = Base32::decode($data,self::ALPHABET32);
                break;
            }
            case self::BASE32UPPER:
            case self::BASE32PADUPPER:{
                $decoded = Base32::decode(strtolower($data),self::ALPHABET32);
                break;
            }
            case self::BASE32Z:{
                $decoded = Base32::decode($data,self::ALPHABET32_ZOOKO);
                break;
            }
            case self::BASE36:{
                $decoded = Base36::decode($data);
                break;
            }
            case self::BASE36UPPER:{
                $decoded = Base36::decode(strtolower($data));
                break;
            }
            case self::BASE58BTC:{
                $decoded = Base58::decode($data,self::ALPHABET58_BITCOIN);
                break;
            }
            case self::BASE58FLICKR:{
                $decoded = Base58::decode($data,self::ALPHABET58_FLICKR);
                break;
            }
            case self::BASE64:
            case self::BASE64PAD:{
                $decoded = Base64::decode($data);
                break;
            }
            case self::BASE64URL:
            case self::BASE64URLPAD:{
                $decoded = Base64::decode(str_replace(['-','_'],['+','/'],$data));
                break;
            }
            default:{
                throw new InvalidArgumentException('Unsupported base decoding: '.$code);
            }
        }
        return $decoded;
    }

    /**
     * @param string $code
     * @param string $data
     * @param bool $addCodePrefix
     * @return string|null
     */
    public static function encode(string $code,string $data,$addCodePrefix=true){
        $encoded = null;
        switch($code){
            case self::IDENTITY:{
                $encoded = $data;
                break;
            }
            case self::BASE2:{
                $encoded = Base2::encode($data);
                break;
            }
            case self::BASE8:{
                $encoded = Base8::encode($data);
                break;
            }
            case self::BASE10:{
                $encoded = Base10::encode($data);
                break;
            }
            case self::BASE16:{
                $encoded = Base16::encode($data);
                break;
            }
            case self::BASE16UPPER:{
                $encoded = strtoupper(Base16::encode($data));
                break;
            }
            case self::BASE32HEX:{
                $encoded = str_replace('=','',Base32::encode($data,self::ALPHABET32_HEX));
                break;
            }
            case self::BASE32HEXUPPER:{
                $encoded = str_replace('=','',strtoupper(Base32::encode($data,self::ALPHABET32_HEX)));
                break;
            }
            case self::BASE32HEXPAD:{
                $encoded = Base32::encode($data,self::ALPHABET32_HEX);
                break;
            }
            case self::BASE32HEXPADUPPER:{
                $encoded = strtoupper(Base32::encode($data,self::ALPHABET32_HEX));
                break;
            }
            case self::BASE32:{
                $encoded = str_replace('=','',Base32::encode($data,self::ALPHABET32));
                break;
            }
            case self::BASE32UPPER:{
                $encoded = str_replace('=','',strtoupper(Base32::encode($data,self::ALPHABET32)));
                break;
            }
            case self::BASE32PAD:{
                $encoded = Base32::encode($data,self::ALPHABET32);
                break;
            }
            case self::BASE32PADUPPER:{
                $encoded = strtoupper(Base32::encode($data,self::ALPHABET32));
                break;
            }
            case self::BASE32Z:{
                $encoded = str_replace('=','',Base32::encode($data,self::ALPHABET32_ZOOKO));
                break;
            }
            case self::BASE36:{
                $encoded = Base36::encode($data);
                break;
            }
            case self::BASE36UPPER:{
                $encoded = strtoupper(Base36::encode($data));
                break;
            }
            case self::BASE58BTC:{
                $encoded = Base58::encode($data,self::ALPHABET58_BITCOIN);
                break;
            }
            case self::BASE58FLICKR:{
                $encoded = Base58::encode($data,self::ALPHABET58_FLICKR);
                break;
            }
            case self::BASE64:{
                $encoded = str_replace('=','',Base64::encode($data));
                break;
            }
            case self::BASE64PAD:{
                $encoded = Base64::encode($data);
                break;
            }
            case self::BASE64URL:{
                $encoded = str_replace('=','',str_replace(['+','/'],['-','_'],Base64::encode($data)));
                break;
            }
            case self::BASE64URLPAD:{
                $encoded = str_replace(['+','/'],['-','_'],Base64::encode($data));
                break;
            }
            default:{
                throw new InvalidArgumentException('Unsupported base encoding: '.$code);
            }
        }
        if($addCodePrefix){
            $encoded = $code.$encoded;
        }
        return $encoded;
    }

}