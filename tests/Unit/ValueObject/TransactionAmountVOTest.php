<?php

namespace Tests\Unit\ValueObject;

use App\Exceptions\InvalidPropertyValueException;
use App\ValueObject\TransactionAmountVO;
use Tests\TestCase;

class TransactionAmountVOTest extends TestCase
{
    /**
     * @throws InvalidPropertyValueException
     */
    public function testValidFloatVO(): void
    {
        $transactionAmount = 10.5;

        $this->assertSame($transactionAmount, (new TransactionAmountVO($transactionAmount))->value);
    }

    /**
     * @throws InvalidPropertyValueException
     */
    public function testInvalidType(): void
    {
        $value = 12;

        $this->expectException(InvalidPropertyValueException::class);
        $this->expectExceptionMessage("The transaction value need's be a float");

        new TransactionAmountVO($value);
    }

    /**
     * @throws InvalidPropertyValueException
     */
    public function testInvalidValue(): void
    {
        $value = -10.5;

        $this->expectException(InvalidPropertyValueException::class);
        $this->expectExceptionMessage('The transaction value cannot be less than 0');

        new TransactionAmountVO($value);
    }
}
