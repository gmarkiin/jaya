<?php

namespace Tests\Unit\ValueObject;

use App\ValueObject\IntegerVO;
use Illuminate\Http\Exceptions\HttpResponseException;
use Tests\TestCase;

class IntegerVOTest extends TestCase
{
    public function testValidIntegerVO(): void
    {
        $value = 12;
        $integerVO = new IntegerVO($value);

        $this->assertSame($value, $integerVO->value);
    }

    public function testInvalidIntegerVO(): void
    {
        $value = 'invalid_value';

        $this->expectException(HttpResponseException::class);
        new IntegerVO($value);
    }

    public function testNegativeIntegerVO(): void
    {
        $value = -12;

        $this->expectException(HttpResponseException::class);
        new IntegerVO($value);
    }

    public function testZeroIntegerVO(): void
    {
        $value = 0;

        $this->expectException(HttpResponseException::class);
        new IntegerVO($value);
    }

    public function testNullIntegerVO(): void
    {
        $value = null;

        $this->expectException(HttpResponseException::class);
        new IntegerVO($value);
    }
}
