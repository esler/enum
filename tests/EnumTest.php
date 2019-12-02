<?php declare(strict_types=1);

namespace IW;

use PHPUnit\Framework\TestCase;

class EnumTest extends TestCase
{

    function testFailWhenInvalidKey() {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Unknown constant: IW\IntraWorldsEnum::KIEV');
        IntraWorldsEnum::KIEV();
    }

    function testMethodEquals() {
        $city = IntraWorldsEnum::PILSEN();

        $this->assertTrue($city->equals(IntraWorldsEnum::PILSEN()));
        $this->assertTrue(IntraWorldsEnum::PILSEN()->equals($city));

        $this->assertFalse($city->equals(IntraWorldsEnum::NEW_YORK()));
        $this->assertFalse(IntraWorldsEnum::TAMPA()->equals($city));
    }

    function testThatTwoInstancesAreTheSame() {
        $this->assertSame(IntraWorldsEnum::TAMPA(), IntraWorldsEnum::TAMPA());
    }

    function testMethodToString() {
        $this->assertSame('1', (string) IntraWorldsEnum::PILSEN());
        $this->assertSame('0.33333333333333', (string) IntraWorldsEnum::TAMPA());
        $this->assertSame('{"foo":["bar"]}', (string) IntraWorldsEnum::MUNICH());
    }

    function testMethodGetValue() {
        $this->assertSame(true, IntraWorldsEnum::PILSEN()->getValue());
        $this->assertSame(['foo' => ['bar']], IntraWorldsEnum::MUNICH()->getValue());
        $this->assertSame(42, IntraWorldsEnum::NEW_YORK()->getValue());
        $this->assertSame(1 / 3, IntraWorldsEnum::TAMPA()->getValue());
    }

    function testMethodGetKey() {
        $this->assertSame('PILSEN', IntraWorldsEnum::PILSEN()->getKey());
        $this->assertSame('MUNICH', IntraWorldsEnum::MUNICH()->getKey());
        $this->assertSame('NEW_YORK', IntraWorldsEnum::NEW_YORK()->getKey());
        $this->assertSame('TAMPA', IntraWorldsEnum::TAMPA()->getKey());
    }

    function testMethodKeys() {
        $this->assertSame(['PILSEN', 'MUNICH', 'NEW_YORK', 'TAMPA'], IntraWorldsEnum::keys());
    }

    function testMethodValues() {
        $this->assertSame([true, ['foo' => ['bar']], 42, 1 / 3], IntraWorldsEnum::values());
    }

    function testMethodToArray() {
        $this->assertSame([
            'PILSEN' => true,
            'MUNICH' => ['foo' => ['bar']],
            'NEW_YORK' => 42,
            'TAMPA' => 1 / 3,
        ], IntraWorldsEnum::toArray());
    }

    function testMethodSearch() {
        $this->assertSame(IntraWorldsEnum::PILSEN(), IntraWorldsEnum::search(true));
        $this->assertSame(IntraWorldsEnum::NEW_YORK(), IntraWorldsEnum::search(42));
        $this->assertNull(IntraWorldsEnum::search(null));
    }
}

/**
 * A value object representing testing enum
 *
 * @method static mixed KIEV()
 *
 * @author Ondrej Esler <ondrej.esler@intraworlds.com>
 */
class IntraWorldsEnum extends Enum
{
    const PILSEN   = true;
    const MUNICH   = ['foo' => ['bar']];
    const NEW_YORK = 42;
    const TAMPA    = 1 / 3;
}
