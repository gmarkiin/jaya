<?php

namespace Tests\Unit\ValueObject;

use App\Domain\Payment\ValueObject\UrlVO;
use App\Exceptions\InvalidPropertyValueException;
use Tests\TestCase;

class UrlVOTest extends TestCase
{
    /**
     * @throws InvalidPropertyValueException
     */
    public function testValidUrlVO(): void
    {
        $url = 'https://webhook.site/e3d32ab9-737a-4832-a5fa-f36a172cec53';

        $this->assertSame($url, (new UrlVO($url))->value);
    }

    public function testInvalidType(): void
    {
        $url = (float)'webhook.site/e3d32ab9-737a-4832-a5fa-f36a172cec53';

        $this->expectException(InvalidPropertyValueException::class);
        $this->expectExceptionMessage("The url '$url' need's be a string");

        new UrlVO($url);
    }

    public function testInvalidValue(): void
    {
        $url = 'webhook.site/e3d32ab9-737a-4832-a5fa-f36a172cec53';

        $this->expectException(InvalidPropertyValueException::class);
        $this->expectExceptionMessage("The url '$url' isn't a UUID");

        new UrlVO($url);
    }
}
