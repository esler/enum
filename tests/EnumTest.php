<?php

declare(strict_types=1);

namespace IW;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use function json_encode;

class EnumTest extends TestCase
{
    public function testFailWhenInvalidKey() : void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Unknown constant: IW\IntraWorldsEnum::KIEV');
        IntraWorldsEnum::KIEV();
    }

    public function testMethodEquals() : void
    {
        $city = IntraWorldsEnum::PILSEN();

        $this->assertTrue($city->equals(IntraWorldsEnum::PILSEN()));
        $this->assertTrue(IntraWorldsEnum::PILSEN()->equals($city));

        $this->assertFalse($city->equals(IntraWorldsEnum::NEW_YORK()));
        $this->assertFalse(IntraWorldsEnum::TAMPA()->equals($city));
    }

    public function testThatTwoInstancesAreTheSame() : void
    {
        $this->assertSame(IntraWorldsEnum::TAMPA(), IntraWorldsEnum::TAMPA());
    }

    public function testMethodToString() : void
    {
        $this->assertSame('1', (string) IntraWorldsEnum::PILSEN());
        $this->assertSame('0.33333333333333', (string) IntraWorldsEnum::TAMPA());
        $this->assertSame('{"foo":["bar"]}', (string) IntraWorldsEnum::MUNICH());
    }

    public function testMethodGetValue() : void
    {
        $this->assertSame(true, IntraWorldsEnum::PILSEN()->getValue());
        $this->assertSame(['foo' => ['bar']], IntraWorldsEnum::MUNICH()->getValue());
        $this->assertSame(42, IntraWorldsEnum::NEW_YORK()->getValue());
        $this->assertSame(1 / 3, IntraWorldsEnum::TAMPA()->getValue());
    }

    public function testMethodGetKey() : void
    {
        $this->assertSame('PILSEN', IntraWorldsEnum::PILSEN()->getKey());
        $this->assertSame('MUNICH', IntraWorldsEnum::MUNICH()->getKey());
        $this->assertSame('NEW_YORK', IntraWorldsEnum::NEW_YORK()->getKey());
        $this->assertSame('TAMPA', IntraWorldsEnum::TAMPA()->getKey());
    }

    public function testMethodKeys() : void
    {
        $this->assertSame(['PILSEN', 'MUNICH', 'NEW_YORK', 'TAMPA'], IntraWorldsEnum::keys());
    }

    public function testMethodValues() : void
    {
        $this->assertSame([true, ['foo' => ['bar']], 42, 1 / 3], IntraWorldsEnum::values());
    }

    public function testMethodToArray() : void
    {
        $this->assertSame([
            'PILSEN' => true,
            'MUNICH' => ['foo' => ['bar']],
            'NEW_YORK' => 42,
            'TAMPA' => 1 / 3,
        ], IntraWorldsEnum::toArray());
    }

    public function testMethodSearch() : void
    {
        $this->assertSame(IntraWorldsEnum::PILSEN(), IntraWorldsEnum::search(true));
        $this->assertSame(IntraWorldsEnum::NEW_YORK(), IntraWorldsEnum::search(42));
        $this->assertNull(IntraWorldsEnum::search(null));
    }

    public function testJsonEncode() : void
    {
        $this->assertSame('true', json_encode(IntraWorldsEnum::PILSEN()));
        $this->assertSame('0.3333333333333333', json_encode(IntraWorldsEnum::TAMPA()));
        $this->assertSame('{"foo":["bar"]}', json_encode(IntraWorldsEnum::MUNICH()));
    }
}
