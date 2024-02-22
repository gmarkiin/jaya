<?php

namespace Tests\Unit\ValueObject;

use App\ValueObject\IdVO;
use Illuminate\Http\Exceptions\HttpResponseException;
use Tests\TestCase;

class IdVOTest extends TestCase
{
    public function testValidIdVO(): void
    {
        $value = '71df6c8a-0f4d-4711-809a-9570db270eee';
        $floatVO = new IdVO($value);

        $this->assertSame($value, $floatVO->value);
    }

    public function testInvalidIdVO(): void
    {
        $value = '0242ac120002';

        $this->expectException(HttpResponseException::class);
        new IdVO($value);
    }

    public function testNullIdVO(): void
    {
        $value = null;

        $this->expectException(HttpResponseException::class);
        new IdVO($value);
    }
}
