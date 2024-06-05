<?php
namespace YOCLIB\Multiformats\Multibase;

class Base256Emoji{

    /**
     * @param string $binary
     * @param array $alphabet
     * @return string
     */
    public static function decode(string $binary,array $alphabet): string{
        $characters = preg_split('//u',$binary, null, PREG_SPLIT_NO_EMPTY);
        $binary = '';
        foreach($characters AS $c){
            $binary = chr(array_search($c,$alphabet,true));
        }
        return $binary;
    }

    /**
     * @param string $data
     * @param array $alphabet
     * @return string
     */
    public static function encode(string $data,array $alphabet): string{
        $binary = Multibase::BASE256EMOJI;
        for($i=0;$i<strlen($data);$i++){
            $binary .= $alphabet[ord($data[$i])];
        }
        return $binary;
    }

}