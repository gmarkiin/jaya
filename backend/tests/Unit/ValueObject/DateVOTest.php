<?php

namespace Tests\Unit\ValueObject;

use App\Domain\Payment\ValueObject\DateVO;
use App\Exceptions\InvalidPropertyValueException;
use Tests\TestCase;

class DateVOTest extends TestCase
{
    /**
     * @throws InvalidPropertyValueException
     */
    public function testValidDate(): void
    {
        $date = date('Y-m-d');

        $this->assertSame($date, (new DateVO($date))->value);
    }

    public function testInvalidType(): void
    {
        $date = 2000/02/20;

        $this->expectException(InvalidPropertyValueException::class);
        $this->expectExceptionMessage("The date need's be a string");

        new DateVO($date);
    }

    public function testEmptyValue(): void
    {
        $date = '';

        $this->expectException(InvalidPropertyValueException::class);
        $this->expectExceptionMessage('The date cannot be empty');

        new DateVO($date);
    }

    public function testInvalidFormat(): void
    {
        $date = '20-02-2000';

        $this->expectException(InvalidPropertyValueException::class);
        $this->expectExceptionMessage("Invalid date format. Date should be in the format 'YYYY-MM-DD'");

        new DateVO($date);
    }
}
