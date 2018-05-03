<?php

use PHPUnit\Framework\TestCase;

use Dec\{
    Dec as Decimal,
    DecConst as DecimalConstants
};

date_default_timezone_set('UTC');


class DecimalSerializationTest extends TestCase
{
    public function testBaseCase()
    {
        $one = Decimal::fromInteger(1);
        $little = Decimal::fromString('0.0000000000001');

        $serialized_one = serialize($one);
        $unserialized_one = unserialize($serialized_one);

        $serialized_little = serialize($little);
        $unserialized_little = unserialize($serialized_little);

        $this->assertTrue($one->equals($unserialized_one));
        $this->assertTrue($little->equals($unserialized_little));
    }
}
