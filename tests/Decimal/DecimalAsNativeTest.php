<?php

use PHPUnit\Framework\TestCase;

use Dec\{
    Dec as Decimal,
    DecConst as DecimalConstants
};

date_default_timezone_set('UTC');


class DecimalAsFloatTest extends TestCase
{
    public function testAsInteger()
    {
        $this->assertEquals(1, Decimal::fromString('1.0')->asInteger());
        $this->assertTrue(is_int(Decimal::fromString('1.0')->asInteger()));

        $this->assertEquals(1, Decimal::fromInteger(1)->asInteger());
        $this->assertTrue(is_int(Decimal::fromInteger(1)->asInteger()));

        $this->assertEquals(1, Decimal::fromFloat(1.0)->asInteger());
        $this->assertEquals(1, Decimal::fromString('1.123123123')->asInteger());

        $this->assertTrue(is_int(Decimal::fromFloat(1.0)->asInteger()));
        $this->assertTrue(is_int(Decimal::fromString('1.123123123')->asInteger()));
    }

    public function testAsFloat()
    {
        $this->assertEquals(1.0, Decimal::fromString('1.0')->asFloat());
        $this->assertTrue(is_float(Decimal::fromString('1.0')->asFloat()));

        $this->assertEquals(1.0, Decimal::fromInteger(1)->asFloat());
        $this->assertTrue(is_float(Decimal::fromInteger(1)->asFloat()));

        $this->assertEquals(1.0, Decimal::fromFloat(1.0)->asFloat());
        $this->assertEquals(1.123123123, Decimal::fromString('1.123123123')->asFloat());

        $this->assertTrue(is_float(Decimal::fromFloat(1.0)->asFloat()));
        $this->assertTrue(is_float(Decimal::fromString('1.123123123')->asFloat()));
    }
}
