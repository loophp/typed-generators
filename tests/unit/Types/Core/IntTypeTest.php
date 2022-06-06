<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace tests\loophp\TypedGenerators\Types\Core;

use LimitIterator;
use loophp\TypedGenerators\Types\Core\IntType;
use PHPUnit\Framework\TestCase;
use function strlen;

/**
 * @internal
 * @coversDefaultClass \loophp\TypedGenerators
 */
final class IntTypeTest extends TestCase
{
    public function intTypeProvider()
    {
        yield [
            'length' => null,
        ];

        yield [
            'length' => 1,
        ];

        yield [
            'length' => 2,
        ];

        yield [
            'length' => 3,
        ];

        yield [
            'length' => 4,
        ];
    }

    /**
     * @dataProvider intTypeProvider
     */
    public function testConstructor(?int $length = null)
    {
        $intType = null === $length
            ? IntType::new()()
            : IntType::new($length)();

        self::assertEquals($length ?? 1, strlen((string) $intType));
    }

    public function testGetIterator()
    {
        $subject = new IntType();

        self::assertInstanceOf('Iterator', $subject->getIterator());

        $iterator = new LimitIterator($subject->getIterator(), 0, 3);

        self::assertCount(3, iterator_to_array($iterator));
    }
}
