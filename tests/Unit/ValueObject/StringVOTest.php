<?php

namespace Tests\Unit\ValueObject;

use App\Exceptions\InvalidPropertyValueException;
use App\ValueObject\StringVO;
use Tests\TestCase;

class StringVOTest extends TestCase
{
    /**
     * @throws InvalidPropertyValueException
     */
    public function testValidString(): void
    {
        $string = 'valid_value';

        $this->assertSame($string, new StringVO($string));
    }

    public function testInvalidType(): void
    {
        $string = 1234;

        $this->expectException(InvalidPropertyValueException::class);
        $this->expectExceptionMessage("The value '$string' need's be a string");

        new StringVO($string);
    }

    /**
     * @throws InvalidPropertyValueException
     */
    public function testEmptyValue(): void
    {
        $value = null;

        $this->expectException(InvalidPropertyValueException::class);
        $this->expectExceptionMessage('The value cannot be empty');

        new StringVO($value);
    }
}
