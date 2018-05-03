<?php
declare(strict_types = 1);

use PHPUnit\Framework\TestCase;

use Dec\{
    Dec as Decimal,
    DecConst as DecimalConstants
};

class DecimalIsGreaterOrEqualToTest extends TestCase
{
    public function testGreater()
    {
        $this->assertTrue(Decimal::fromFloat(1.01)->isGreaterOrEqualTo(Decimal::fromFloat(1.001)));
    }

    public function testEqual()
    {
        $this->assertTrue(Decimal::fromFloat(1.001)->isGreaterOrEqualTo(Decimal::fromFloat(1.001)));
    }

    public function testLess()
    {
        $this->assertFalse(Decimal::fromFloat(1.001)->isGreaterOrEqualTo(Decimal::fromFloat(1.01)));
    }
}
