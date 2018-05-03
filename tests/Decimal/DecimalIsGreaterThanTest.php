<?php
declare(strict_types = 1);

use PHPUnit\Framework\TestCase;

use Dec\{
    Dec as Decimal,
    DecConst as DecimalConstants
};

class DecimalIsGreaterThanTest extends TestCase
{
    public function testGreater()
    {
        $this->assertTrue(Decimal::fromFloat(1.01)->isGreaterThan(Decimal::fromFloat(1.001)));
    }

    public function testEqual()
    {
        $this->assertFalse(Decimal::fromFloat(1.001)->isGreaterThan(Decimal::fromFloat(1.001)));
    }

    public function testLess()
    {
        $this->assertFalse(Decimal::fromFloat(1.001)->isGreaterThan(Decimal::fromFloat(1.01)));
    }
}
