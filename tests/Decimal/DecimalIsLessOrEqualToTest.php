<?php
declare(strict_types = 1);

use PHPUnit\Framework\TestCase;

use Dec\{
    Dec as Decimal,
    DecConst as DecimalConstants
};

class DecimalIsLessOrEqualToTest extends TestCase
{
    public function testGreater()
    {
        $this->assertFalse(Decimal::fromFloat(1.01)->isLessOrEqualTo(Decimal::fromFloat(1.001)));
    }

    public function testEqual()
    {
        $this->assertTrue(Decimal::fromFloat(1.001)->isLessOrEqualTo(Decimal::fromFloat(1.001)));
    }

    public function testLess()
    {
        $this->assertTrue(Decimal::fromFloat(1.001)->isLessOrEqualTo(Decimal::fromFloat(1.01)));
    }
}
