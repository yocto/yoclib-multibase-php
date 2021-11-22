<?php
namespace YOCLIB\Multiformats\Multibase;

class Base32{

    public static function decode(string $data,string $alphabet): string{
        if (empty($data)) {
            return '';
        }

        $data = str_split($data);
        $data = array_map(static function ($character) use($alphabet) {
            if ($character !== $alphabet[strlen($alphabet)-1]) {
                $index = strpos($alphabet, $character);
                return sprintf('%05b', $index);
            }
        }, $data);
        $binary = implode('', $data);

        /* Split to eight bit chunks. */
        $data = str_split($binary, 8);

        /* Make sure binary is divisible by eight by ignoring the incomplete byte. */
        $last = array_pop($data);
        if ((null !== $last) && (8 === strlen($last))) {
            $data[] = $last;
        }

        return implode('', array_map(function ($byte) {
            return chr((int)bindec($byte));
        }, $data));
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