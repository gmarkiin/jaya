<?php

namespace Tests\Unit\ValueObject;

use App\ValueObject\StringVO;
use Illuminate\Http\Exceptions\HttpResponseException;
use Tests\TestCase;

class StringVOTest extends TestCase
{
    public function testValidStringVO(): void
    {
        $value = 'valid_value';
        $stringVO = new StringVO($value);

        $this->assertSame($value, $stringVO->value);
    }

    public function testInvalidStringVO(): void
    {
        $value = 1234;

        $this->expectException(HttpResponseException::class);
        new StringVO($value);
    }

    public function testNullStringVO(): void
    {
        $value = null;

        $this->expectException(HttpResponseException::class);
        new StringVO($value);
    }
}
