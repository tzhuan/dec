<?php

namespace Dec;

use Litipk\BigNumbers\Decimal as D;
use Litipk\BigNumbers\DecimalConstants as DC;

class DecConst
{
    public static function __callStatic($method, $args)
    {
        $r = DC::$method(...$args);
        return $r instanceof D ? Dec::create($r) : $r;
    }
}
