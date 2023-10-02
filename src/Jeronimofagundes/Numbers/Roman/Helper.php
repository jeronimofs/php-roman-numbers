<?php
/**
 * Class Jeronimofagundes\Numbers\Roman\Helper.
 *
 * This helper provides methods to perform conversion between arabic and roman numbers.
 *
 * @author Jerônimo Fagundes da Silva <jeronimo.fs@protonmail.com>.
 *
 * @license MIT.
 *
 */

declare(strict_types=1);

namespace Jeronimofagundes\Numbers\Roman;

use
    \OutOfBoundsException,
    \InvalidArgumentException,
    \TypeError;

/**
 * Class Helper.
 *
 * Provides methods to perform conversion between arabic and roman numbers.
 *
 */
class Helper
{
    /**
     * @var The minimum convertable value to/from roman.
     */
    public const MIN_VALUE = 1;

    /**
     * @var The maximum convertable value to/from roman.
     */
    public const MAX_VALUE = 3999;

    /**
     * @var Array with predefined values to help arabic->roman conversion.
     */
    private const TO_ROMAN = [
        1 => [
            0 => '',
            1 => 'I',
            2 => 'II',
            3 => 'III',
            4 => 'IV',
            5 => 'V',
            6 => 'VI',
            7 => 'VII',
            8 => 'VIII',
            9 => 'IX'
        ],
        10 => [
            0 => '',
            1 => 'X',
            2 => 'XX',
            3 => 'XXX',
            4 => 'XL',
            5 => 'L',
            6 => 'LX',
            7 => 'LXX',
            8 => 'LXXX',
            9 => 'XC'
        ],
        100 => [
            0 => '',
            1 => 'C',
            2 => 'CC',
            3 => 'CCC',
            4 => 'CD',
            5 => 'D',
            6 => 'DC',
            7 => 'DCC',
            8 => 'DCCC',
            9 => 'CM'
        ],
        1000 => [
            0 => '',
            1 => 'M',
            2 => 'MM',
            3 => 'MMM'
        ]
    ];

    /**
     * @var Array with predefined values to help roman->arabic conversion.
     */
    private const FROM_ROMAN = [
        'I'  => 1,
        'IV' => 4,
        'V'  => 5,
        'IX' => 9,
        'X'  => 10,
        'XL' => 40,
        'L'  => 50,
        'XC' => 90,
        'C'  => 100,
        'CD' => 400,
        'D'  => 500,
        'CM' => 900,
        'M'  => 1000
    ];

    /**
     * Checks if a given arabic value is inside the convertable range.
     * @param int $value The number to be converted.
     */
    private static function insideValidRange(int $value)
    {
        return static::MIN_VALUE <= $value && $value <= static::MAX_VALUE;
    }

    /**
     * Converts an arabic to a roman number.
     * @param int $value The arabic number to be converted.
     * @return string The roman number which represents the given value.
     * @throws OutOfBoundsException When the given number out of the range of convertable values.
     * @throws TypeError If the parameter $value is not an int.
     */
    public static function fromArabic(int $value)
    {
        if (!static::insideValidRange($value)) {
            throw new OutOfBoundsException('value shall be between ' . static::MIN_VALUE  . ' and ' . static::MAX_VALUE);
        }

        $strValue = sprintf("%04d", $value);

        return
            static::TO_ROMAN[1000][$strValue[0]] .
            static::TO_ROMAN[ 100][$strValue[1]] .
            static::TO_ROMAN[  10][$strValue[2]] .
            static::TO_ROMAN[   1][$strValue[3]];
    }

    /**
     * Converts a roman number to an arabic one.
     * @param string $roman The roman number to be converted.
     * @return integer The arabic number which represents the given value.
     * @throws InvalidArgumentException If the given roman number is invalid.
     * @throws TypeError If the parameter $roman is not a string.
     */
    public static function toArabic(string $roman)
    {
        $roman = strtoupper($roman);
        if (!preg_match('/^M{0,3}(CM|CD|D?C{0,3})(XC|XL|L?X{0,3})(IX|IV|V?I{0,3})$/', $roman)) {
            throw new InvalidArgumentException('roman shall be a roman numeral composed by the following characters: I,V,X,L,C,D,M');
        }

        $ret = 0;

        for ($i=0; $i<strlen($roman); $i++) {
            $currentChar = substr($roman, $i, 2);

            if (!array_key_exists($currentChar, static::FROM_ROMAN)) {
                $currentChar = $roman[$i];
            }

            $ret += static::FROM_ROMAN[$currentChar];

            $i += strlen($currentChar)-1;
        }

        return $ret;
    }
}