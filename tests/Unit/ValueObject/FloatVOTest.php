<?php

namespace Tests\Unit\ValueObject;

use App\ValueObject\FloatVO;
use Illuminate\Http\Exceptions\HttpResponseException;
use Tests\TestCase;

class FloatVOTest extends TestCase
{
    public function testValidFloatVO(): void
    {
        $value = 10.5;
        $floatVO = new FloatVO($value);

        $this->assertSame($value, $floatVO->value);
    }

    public function testInvalidFloatVO(): void
    {
        $value = 'invalid_value';

        $this->expectException(HttpResponseException::class);
        new FloatVO($value);
    }

    public function testNegativeFloatVO(): void
    {
        $value = -10.5;

        $this->expectException(HttpResponseException::class);
        new FloatVO($value);
    }

    public function testZeroFloatV0(): void
    {
        $value = 0.0;

        $this->expectException(HttpResponseException::class);
        new FloatVO($value);
    }

    public function testNullFloatVO(): void
    {
        $value = null;

        $this->expectException(HttpResponseException::class);
        new FloatVO($value);
    }
}
