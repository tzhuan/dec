<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use Dec\{
    Dec as Decimal,
    DecConst as DecimalConstants
};

class issue55Test extends TestCase
{
    public function test_that_forcing_concrete_precision_on_creation_does_not_corrupt_the_passed_value()
    {
        $this->assertEquals(4.0, Decimal::create(4.0, 8)->asFloat());
    }
}
