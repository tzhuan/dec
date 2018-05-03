<?php

use PHPUnit\Framework\TestCase;

use Dec\{
    Dec as Decimal,
    DecConst as DecimalConstants
};

date_default_timezone_set('UTC');

class DecimalEqualsTest extends TestCase
{
    public function testSimpleEquals()
    {
        // Transitivity & inter-types constructors compatibility
        $this->assertTrue(Decimal::fromInteger(1)->equals(Decimal::fromString("1")));
        $this->assertTrue(Decimal::fromString("1")->equals(Decimal::fromFloat(1.0)));
        $this->assertTrue(Decimal::fromInteger(1)->equals(Decimal::fromFloat(1.0)));

        // Reflexivity
        $this->assertTrue(Decimal::fromInteger(1)->equals(Decimal::fromInteger(1)));

        // Symmetry
        $this->assertTrue(Decimal::fromString("1")->equals(Decimal::fromInteger(1)));
        $this->assertTrue(Decimal::fromFloat(1.0)->equals(Decimal::fromString("1")));
        $this->assertTrue(Decimal::fromFloat(1.0)->equals(Decimal::fromInteger(1)));
    }

    public function testSimpleNotEquals()
    {
        // Symmetry
        $this->assertFalse(Decimal::fromInteger(1)->equals(Decimal::fromInteger(2)));
        $this->assertFalse(Decimal::fromInteger(2)->equals(Decimal::fromInteger(1)));

        $this->assertFalse(Decimal::fromFloat(1.01)->equals(Decimal::fromInteger(1)));
        $this->assertFalse(Decimal::fromInteger(1)->equals(Decimal::fromFloat(1.01)));
    }

    public function testScaledEquals()
    {
        // Transitivity
        $this->assertTrue(Decimal::fromFloat(1.001)->equals(Decimal::fromFloat(1.01), 1));
        $this->assertTrue(Decimal::fromFloat(1.01)->equals(Decimal::fromFloat(1.004), 1));
        $this->assertTrue(Decimal::fromFloat(1.001)->equals(Decimal::fromFloat(1.004), 1));

        // Reflexivity
        $this->assertTrue(Decimal::fromFloat(1.00525)->equals(Decimal::fromFloat(1.00525), 2));

        // Symmetry
        $this->assertTrue(Decimal::fromFloat(1.01)->equals(Decimal::fromFloat(1.001), 1));
        $this->assertTrue(Decimal::fromFloat(1.004)->equals(Decimal::fromFloat(1.01), 1));
        $this->assertTrue(Decimal::fromFloat(1.004)->equals(Decimal::fromFloat(1.001), 1));

        // Proper rounding
        $this->assertTrue(Decimal::fromFloat(1.004)->equals(Decimal::fromFloat(1.000), 2));

        // Warning, float to Decimal conversion can have unexpected behaviors, like converting
        // 1.005 to Decimal("1.0049999999999999")
        $this->assertTrue(Decimal::fromFloat(1.0050000000001)->equals(Decimal::fromFloat(1.010), 2));

        $this->assertTrue(Decimal::fromString("1.005")->equals(Decimal::fromString("1.010"), 2));
    }

    public function testScaledNotEquals()
    {
        # Proper rounding
        $this->assertFalse(Decimal::fromFloat(1.004)->equals(Decimal::fromFloat(1.0050000000001), 2));
    }
}
