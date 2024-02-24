<?php

namespace Tests\Unit\ValueObject;

use App\ValueObject\UrlVO;
use Illuminate\Http\Exceptions\HttpResponseException;
use Tests\TestCase;

class UrlVOTest extends TestCase
{
    public function testValidUrlVO(): void
    {
        $value = 'https://webhook.site/e3d32ab9-737a-4832-a5fa-f36a172cec53';
        $urlVO = new UrlVO($value);

        $this->assertSame($value, $urlVO->value);
    }

    public function testInvalidUrlVO(): void
    {
        $value = 'ebhook.site/e3d32ab9-737a-4832-a5fa-f36a172cec53';

        $this->expectException(HttpResponseException::class);
        new UrlVO($value);
    }
}
