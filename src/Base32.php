<?php
namespace YOCLIB\Multiformats\Multibase;

class Base32{

    public static function decode(string $data,string $alphabet): string{
        $flippedAlphabet = array_flip(str_split($alphabet));
        $binary = '';
        for($i=0;$i<strlen($data);$i++){
            $char = strtolower($data[$i]);
            if($char==='='){
                continue;
            }
            $binaryChunk = decbin($flippedAlphabet[$char]);
            while(strlen($binaryChunk)%5!==0){
                $binaryChunk = '0'.$binaryChunk;
            }
            $binary .= $binaryChunk;
        }
        $padding = strlen($binary)%8;
        if($padding!==0){
            $binary = substr($binary,0,-$padding);
        }
        return Base2::decode($binary);


//        $map = str_split($alphabet);
//        $flippedMap = array_flip($map);
//
//        $paddingCharCount = substr_count($data, $map[32]);
//        $allowedValues = array(6,4,3,1,0);
//        if(!in_array($paddingCharCount, $allowedValues)) return false;
//        for($i=0; $i<4; $i++){
//            if($paddingCharCount == $allowedValues[$i] &&
//                substr($data, -($allowedValues[$i])) != str_repeat($map[32], $allowedValues[$i])) return false;
//        }
//        $data = str_replace('=','', $data);
//        $data = str_split($data);
//        $binaryString = "";
//        for($i=0; $i < count($data); $i = $i+8) {
//            $x = "";
//            if(!in_array($data[$i], $map)) return false;
//            for($j=0; $j < 8; $j++) {
//                $x .= str_pad(base_convert(@$flippedMap[@$data[$i + $j]], 10, 2), 5, '0', STR_PAD_LEFT);
//            }
//            $eightBits = str_split($x, 8);
//            for($z = 0; $z < count($eightBits); $z++) {
//                $binaryString .= ( ($y = chr(base_convert($eightBits[$z], 2, 10))) || ord($y) == 48 ) ? $y:"";
//            }
//        }
//        return $binaryString;
    }

    public static function encode(string $data,string $alphabet): string{
        // Empty string results in empty string
        if ('' === $data) {
            return '';
        }

        $encoded = '';

        //Set the initial values
        $n = $bitLen = $val = 0;
        $len = strlen($data);

        //Pad the end of the string - this ensures that there are enough zeros
        $data .= str_repeat(chr(0), 4);

        //Explode string into integers
        $chars = (array) unpack('C*', $data, 0);

        while ($n < $len || 0 !== $bitLen) {
            //If the bit length has fallen below 5, shift left 8 and add the next character.
            if ($bitLen < 5) {
                $val = $val << 8;
                $bitLen += 8;
                $n++;
                $val += $chars[$n];
            }
            $shift = $bitLen - 5;
            $encoded .= ($n - (int)($bitLen > 8) > $len && 0 == $val) ? '=' : $alphabet[$val >> $shift];
            $val = $val & ((1 << $shift) - 1);
            $bitLen -= 5;
        }

        return strtolower($encoded);
    }

}