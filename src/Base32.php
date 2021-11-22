<?php
namespace YOCLIB\Multiformats\Multibase;

class Base32{

    protected const ALPHABET = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567=';

    protected const BASE32HEX_PATTERN = '/[^A-Z2-7]/';

//    protected const ALPHABET = '0123456789ABCDEFGHIJKLMNOPQRSTUV=';
//
//    protected const BASE32HEX_PATTERN = '/[^0-9A-V]/';

    protected const MAPPING = [
        '=' => 0b00000,
        'A' => 0b00000,
        'B' => 0b00001,
        'C' => 0b00010,
        'D' => 0b00011,
        'E' => 0b00100,
        'F' => 0b00101,
        'G' => 0b00110,
        'H' => 0b00111,
        'I' => 0b01000,
        'J' => 0b01001,
        'K' => 0b01010,
        'L' => 0b01011,
        'M' => 0b01100,
        'N' => 0b01101,
        'O' => 0b01110,
        'P' => 0b01111,
        'Q' => 0b10000,
        'R' => 0b10001,
        'S' => 0b10010,
        'T' => 0b10011,
        'U' => 0b10100,
        'V' => 0b10101,
        'W' => 0b10110,
        'X' => 0b10111,
        'Y' => 0b11000,
        'Z' => 0b11001,
        '2' => 0b11010,
        '3' => 0b11011,
        '4' => 0b11100,
        '5' => 0b11101,
        '6' => 0b11110,
        '7' => 0b11111,
    ];

    protected const MAPPING_HEX = [
        '=' => 0b00000,
        '0' => 0b00000,
        '1' => 0b00001,
        '2' => 0b00010,
        '3' => 0b00011,
        '4' => 0b00100,
        '5' => 0b00101,
        '6' => 0b00110,
        '7' => 0b00111,
        '8' => 0b01000,
        '9' => 0b01001,
        'A' => 0b01010,
        'B' => 0b01011,
        'C' => 0b01100,
        'D' => 0b01101,
        'E' => 0b01110,
        'F' => 0b01111,
        'G' => 0b10000,
        'H' => 0b10001,
        'I' => 0b10010,
        'J' => 0b10011,
        'K' => 0b10100,
        'L' => 0b10101,
        'M' => 0b10110,
        'N' => 0b10111,
        'O' => 0b11000,
        'P' => 0b11001,
        'Q' => 0b11010,
        'R' => 0b11011,
        'S' => 0b11100,
        'T' => 0b11101,
        'U' => 0b11110,
        'V' => 0b11111,
    ];

    public static function decode(string $data): string{
        // Only work in upper cases
        $base32String = strtoupper($data);

        // Remove anything that is not base32 alphabet
        $base32String = preg_replace(static::BASE32HEX_PATTERN, '', $base32String);

        // Empty string results in empty string
        if ('' === $base32String || null === $base32String) {
            return '';
        }

        $decoded = '';

        //Set the initial values
        $len = strlen($base32String);
        $n = 0;
        $bitLen = 5;
        $val = static::MAPPING[$base32String[0]];

        while ($n < $len) {
            //If the bit length has fallen below 8, shift left 5 and add the next pentet.
            if ($bitLen < 8) {
                $val = $val << 5;
                $bitLen += 5;
                $n++;
                $pentet = $base32String[$n] ?? '=';

                //If the new pentet is padding, make this the last iteration.
                if ('=' === $pentet) {
                    $n = $len;
                }
                $val += static::MAPPING[$pentet];
            } else {
                $shift = $bitLen - 8;

                $decoded .= \chr($val >> $shift);
                $val = $val & ((1 << $shift) - 1);
                $bitLen -= 8;
            }
        }

        return $decoded;
    }

    public static function encode(string $data): string{
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
            $encoded .= ($n - (int)($bitLen > 8) > $len && 0 == $val) ? '=' : static::ALPHABET[$val >> $shift];
            $val = $val & ((1 << $shift) - 1);
            $bitLen -= 5;
        }

        return $encoded;
    }

}