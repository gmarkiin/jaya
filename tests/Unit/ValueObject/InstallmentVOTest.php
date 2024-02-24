<?php

namespace Tests\Unit\ValueObject;

use App\Exceptions\InvalidPropertyValueException;
use App\ValueObject\InstallmentVO;
use Tests\TestCase;

class InstallmentVOTest extends TestCase
{
    /**
     * @throws InvalidPropertyValueException
     */
    public function testValidInstallmentValue(): void
    {
        $installment = 12;

        $this->assertSame($installment, (new InstallmentVO($installment))->value);
    }

    /**
     * @throws InvalidPropertyValueException
     */
    public function testInvalidType(): void
    {
        $value = '123';

        $this->expectException(InvalidPropertyValueException::class);
        $this->expectExceptionMessage("The installment need's be a integer");

        new InstallmentVO($value);
    }

    /**
     * @throws InvalidPropertyValueException
     */
    public function testNegativeValue(): void
    {
        $value = -12;

        $this->expectException(InvalidPropertyValueException::class);
        $this->expectExceptionMessage('The installment cannot be less than 0');

        new InstallmentVO($value);
    }
}
