<?php
declare(strict_types=1);

namespace PhpDynamicCast;

use PHPUnit\Framework\TestCase;

final class functionTest extends TestCase
{
    /**
     * @throws TypeException
     */
    public function testCastBool()
    {
        $this->assertSame(true, cast(1, 'bool'));
        $this->assertSame(false, cast(0, 'bool'));
        $this->assertSame(true, cast(true, 'bool'));

        $this->assertSame(true, cast(1, 'boolean'));
        $this->assertSame(false, cast(0, 'boolean'));
        $this->assertSame(true, cast(true, 'boolean'));
    }

    /**
     * @throws TypeException
     */
    public function testCastInteger()
    {
        $this->assertSame(1, cast(1.0, 'int'));
        $this->assertSame(0, cast(0.9, 'int'));

        $this->assertSame(1, cast(1.0, 'integer'));
        $this->assertSame(0, cast(0.9, 'integer'));
    }

    /**
     * @throws TypeException
     */
    public function testCastFloat()
    {
        $this->assertSame(1.0, cast(1, 'float'));
        $this->assertSame(0.1, cast(0.1, 'float'));

        $this->assertSame(1.0, cast(1, 'double'));
        $this->assertSame(0.1, cast(0.1, 'double'));
    }

    /**
     * @throws TypeException
     */
    public function testCastString()
    {
        $this->assertSame('1', cast(1, 'string'));
        $this->assertSame('hi', cast('hi', 'string'));
    }

    /**
     * @throws TypeException
     */
    public function testCastByClosure()
    {
        $this->assertSame('@1', cast(1, function ($v) {
            return '@' . $v;
        }));

        $this->assertNull(cast(1, function ($v) {
        }));
    }

    /**
     * @throws TypeException
     */
    public function testCastByFunction()
    {
        $this->assertSame(6, cast(3, __NAMESPACE__ . '\toDouble'));
    }

    /**
     * @throws TypeException
     * @throws \PHPUnit\Framework\Exception
     */
    public function testCastByClassMethod()
    {
        $actual = cast(true, DummyText::class . '::fromBool');

        $this->assertSame('on', $actual->val);
        $this->assertInstanceOf(DummyText::class, $actual);
    }

    /**
     * @throws TypeException
     * @throws \PHPUnit\Framework\Exception
     */
    public function testCastByClass()
    {
        $actual = cast('hi', DummyText::class);

        $this->assertSame('hi', $actual->val);
        $this->assertInstanceOf(DummyText::class, $actual);
    }

    /**
     * @throws TypeException
     * @throws \PHPUnit\Framework\Exception
     */
    public function throwsExceptionWithUndefinedType()
    {
        $this->expectException(TypeException::class);

        cast(0, 'undefined type');
    }
}

class DummyText
{
    public $val;

    public function __construct(string $val)
    {
        $this->val = $val;
    }

    public static function fromBool(bool $val): self
    {
        return new self($val ? 'on' : 'off');
    }
}

function toDouble($num)
{
    return $num * 2;
}
