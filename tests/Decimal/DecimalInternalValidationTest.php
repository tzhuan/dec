<?php

use PHPUnit\Framework\TestCase;

use Dec\{
    Dec as Decimal,
    DecConst as DecimalConstants
};

date_default_timezone_set('UTC');

class DecimalInternalValidationTest extends TestCase
{
    /**
     * @expectedException \TypeError
     */
    public function testConstructorNullValueValidation()
    {
        Decimal::fromInteger(null);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage $scale must be a positive integer
     */
    public function testConstructorNegativeScaleValidation()
    {
        Decimal::fromString("25", -15);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage $scale must be a positive integer
     */
    public function testOperatorNegativeScaleValidation()
    {
        $one = Decimal::fromInteger(1);

        $one->mul($one, -1);
    }
}
