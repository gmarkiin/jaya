<?php

namespace Tests\Unit\ValueObject;

use App\Domain\Payment\ValueObject\IdVO;
use App\Exceptions\InvalidPropertyValueException;
use Tests\TestCase;

class IdVOTest extends TestCase
{
    /**
     * @throws InvalidPropertyValueException
     */
    public function testValidIdVO(): void
    {
        $id = '71df6c8a-0f4d-4711-809a-9570db270eee';

        $this->assertSame($id, (new IdVO($id))->value);
    }

    /**
     * @throws InvalidPropertyValueException
     */
    public function testInvalidId(): void
    {
        $id = '0242ac120002';

        $this->expectException(InvalidPropertyValueException::class);
        $this->expectExceptionMessage("The ID '$id' isn't a UUID");

        new IdVO($id);
    }

    /**
     * @throws InvalidPropertyValueException
     */
    public function testInvalidType(): void
    {
        $id = null;

        $this->expectException(InvalidPropertyValueException::class);
        $this->expectExceptionMessage("The ID '$id' need's be a string");

        new IdVO($id);
    }
}
