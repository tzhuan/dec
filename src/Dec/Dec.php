<?php

namespace Dec;

use Error;
use ReflectionMethod;

use Litipk\BigNumbers\Decimal as D;
use Litipk\BigNumbers\DecimalConstants as DC;

class Dec
{
    const UNARY_OPS = [ # {{{
        'sqrt' => 'sqrt',
        'log10' => 'log10',
        'isZero' => 'isZero',
        'isPositive' => 'isPositive',
        'isNegative' => 'isNegative',
        'minus' => 'additiveInverse',
        'round' => 'round',
        'ceil' => 'ceil',
        'floor' => 'floor',
        'abs' => 'abs',
        'sin' => 'sin',
        'cosec' => 'cosec',
        'cos' => 'cos',
        'sec' => 'sec',
        'tan' => 'tan',
        'cotan' => 'cotan',
        'arcsin' => 'arcsin',
        'arccos' => 'arccos',
        'arctan' => 'arctan',
        'arccot' => 'arccot',
        'arcsec' => 'arcsec',
        'arccsc' => 'arccsc',
        'exp' => 'exp',
    ]; # }}}
    const BINARY_OPS = [ # {{{
        'eq' => 'equals',
        'lt' => 'isLessThan',
        'lte' => 'isLessOrEqualTo',
        'gt' => 'isGreaterThan',
        'gte' => 'isGreaterOrEqualTo',
        'add' => 'add',
        'sub' => 'sub',
        'mul' => 'mul',
        'div' => 'div',
        'pow' => 'pow',
        'mod' => 'mod',
        'eqSign' => 'hasSameSign',
    ]; # }}}

    private $decimal;

    private function __construct(D $decimal)
    {
        $this->decimal = $decimal;
    }

    public static function create($value, int $scale = null): Dec
    {
        if ($value instanceof static) {
            if ($scale === null) {
                return $value;
            }
            return new static(D::create($value->decimal, $scale));
        }
        return new static(D::create($value, $scale));
    }

    public function __toString()
    {
        return (string)$this->decimal;
    }

    public function __call($method, $args)
    {
        # bypass to Decimal
        list($found, $result) =
            static::proxy($method, $args, D::class, $this->decimal);
        if ($found) {
            return $result;
        }
        throw new Error("Call to undefined method Dec::$method()");
    }

    public static function __callStatic($method, $args)
    {
        # uniry operators
        if (isset(static::UNARY_OPS[$method]) and count($args) >= 1) {
            $a = static::create(array_shift($args))->decimal;
            $r = $a->{static::UNARY_OPS[$method]}(...$args);
            return $r instanceof D ? new static($r) : $r;
        }

        # binary operators
        if (isset(static::BINARY_OPS[$method]) and count($args) >= 2) {
            $a = static::create(array_shift($args))->decimal;
            $args[0] = static::create($args[0])->decimal;
            $r = $a->{static::BINARY_OPS[$method]}(...$args);
            return $r instanceof D ? new static($r) : $r;
        }

        # bypass to Decimal
        list($found, $result) = static::proxy($method, $args, D::class);
        if ($found) {
            return $result;
        }

        throw new Error("Call to undefined method Dec::$method()");
    }

    private static function proxy(
        string $method,
        array $args,
        string $class,
        D $object = null
    ) {
        $isStatic = $object ? false : true;
        if (method_exists($class, $method)) {
            $rm = new ReflectionMethod($class, $method);
            if ($rm->isPublic() and $rm->isStatic() === $isStatic) {
                foreach ($rm->getParameters() as $i => $parameter) {
                    if ((string)$parameter->getType() === D::class and
                        isset($args[$i]) and
                        !($args[$i] instanceof D)) {
                        if ($args[0] instanceof static) {
                            $args[0] = $args[0]->decimal;
                        } else {
                            $args[0] = D::create($args[0]);
                        }
                    }
                }

                # invoke it!
                $r = $object ?
                    $object->$method(...$args) : $class::$method(...$args);
                return [true, $r instanceof D ? new static($r) : $r];
            }
        }
        return [false, null];
    }
}
