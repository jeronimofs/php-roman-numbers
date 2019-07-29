<?php
declare(strict_types=1);

use
    \PHPUnit\Framework\TestCase,
    \Jeronimofagundes\Numbers\Roman\Helper;

final class HelperTest extends TestCase {
    private const PREDEF_ROMAN_NUMBERS = [
        'I'             => 1,
        'IV'            => 4,
        'V'             => 5,
        'IX'            => 9,
        'X'             => 10,
        'XL'            => 40,
        'L'             => 50,
        'XC'            => 90,
        'C'             => 100,
        'CD'            => 400,
        'D'             => 500,
        'CM'            => 900,
        'M'             => 1000,
        'MMXIX'         => 2019,
        'DCCLXXXVII'    => 787,
        'XLII'          => 42

    ];

    public function testArabicToRomanReturnsString()
    {
        $this->assertIsString(Helper::fromArabic(rand(Helper::MIN_VALUE, Helper::MAX_VALUE)));
    }

    public function testRomanToArabicReturnsInt()
    {
        $this->assertIsInt(Helper::toArabic('MMXIX'));
    }

    public function testArabicToRomanRefusesNotInt()
    {
        $this->expectException(TypeError::class);
        Helper::fromArabic('89');
    }

    public function testRomanToRefusesNotString()
    {
        $this->expectException(TypeError::class);
        Helper::toArabic(89);
    }

    public function testRefusesConvertNumbersLessThanMinimum()
    {
        $this->expectException(OutOfBoundsException::class);
        Helper::fromArabic(rand() * -1);
    }

    public function testRefusesInvalidCharacters()
    {
        $this->expectException(InvalidArgumentException::class);
        Helper::toArabic('MCXJOAO0123');
    }

    public function testRefusesInvalidLiteralIL()
    {
        $this->expectException(InvalidArgumentException::class);
        Helper::toArabic('IL');
    }

    public function testRefusesInvalidLiteralIC()
    {
        $this->expectException(InvalidArgumentException::class);
        Helper::toArabic('IC');
    }

    public function testRefusesInvalidLiteralID()
    {
        $this->expectException(InvalidArgumentException::class);
        Helper::toArabic('ID');
    }

    public function testRefusesInvalidLiteralIM()
    {
        $this->expectException(InvalidArgumentException::class);
        Helper::toArabic('IM');
    }

    public function testRefusesInvalidLiteralVX()
    {
        $this->expectException(InvalidArgumentException::class);
        Helper::toArabic('VX');
    }

    public function testRefusesInvalidLiteralVL()
    {
        $this->expectException(InvalidArgumentException::class);
        Helper::toArabic('VL');
    }

    public function testRefusesInvalidLiteralVC()
    {
        $this->expectException(InvalidArgumentException::class);
        Helper::toArabic('VC');
    }

    public function testRefusesInvalidLiteralVD()
    {
        $this->expectException(InvalidArgumentException::class);
        Helper::toArabic('VD');
    }

    public function testRefusesInvalidLiteralVM()
    {
        $this->expectException(InvalidArgumentException::class);
        Helper::toArabic('VM');
    }

    public function testRefusesInvalidLiteralXD()
    {
        $this->expectException(InvalidArgumentException::class);
        Helper::toArabic('XD');
    }

    public function testRefusesInvalidLiteralXM()
    {
        $this->expectException(InvalidArgumentException::class);
        Helper::toArabic('XM');
    }

    public function testRefusesInvalidLiteralLC()
    {
        $this->expectException(InvalidArgumentException::class);
        Helper::toArabic('LC');
    }

    public function testRefusesInvalidLiteralLD()
    {
        $this->expectException(InvalidArgumentException::class);
        Helper::toArabic('LD');
    }

    public function testRefusesInvalidLiteralLM()
    {
        $this->expectException(InvalidArgumentException::class);
        Helper::toArabic('LM');
    }

    public function testRefusesInvalidLiteralDM()
    {
        $this->expectException(InvalidArgumentException::class);
        Helper::toArabic('DM');
    }

    public function testArabicToRomanConversions()
    {
        foreach (static::PREDEF_ROMAN_NUMBERS as $roman => $arabic) {
            $this->assertEquals($roman, Helper::fromArabic($arabic));
        }
    }

    public function testRomanToArabicConversions()
    {
        foreach (static::PREDEF_ROMAN_NUMBERS as $roman => $arabic) {
            $this->assertEquals($arabic, Helper::toArabic($roman));
        }
    }

    public function testAllRangeArabicToRomanToArabic()
    {
        for ($i = Helper::MIN_VALUE; $i <= Helper::MAX_VALUE; $i++) {
            $this->assertEquals($i, Helper::toArabic(Helper::fromArabic($i)));
        }
    }
}
