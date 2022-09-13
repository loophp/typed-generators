<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace tests\loophp\TypedGenerators\Types\Hybrid;

use LimitIterator;
use loophp\TypedGenerators\Types\Core\BoolType;
use loophp\TypedGenerators\Types\Core\StringType;
use loophp\TypedGenerators\Types\Hybrid\Union;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversDefaultClass \loophp\TypedGenerators
 */
final class UnionTest extends TestCase
{
    public function testConstructor()
    {
        $subject = new Union(new BoolType(), new BoolType());

        self::assertIsBool($subject());
    }

    public function testGetIterator()
    {
        $subject = new Union(new BoolType(), new BoolType());

        self::assertInstanceOf('Iterator', $subject->getIterator());

        $iterator = new LimitIterator($subject->getIterator(), 0, 3);

        self::assertCount(3, iterator_to_array($iterator));
    }

    public function testIdentity()
    {
        $subject = new Union(new StringType(), new BoolType());

        $string = 'Hello';
        $bool = true;

        self::assertSame($string, $subject->identity($string));
        self::assertSame($bool, $subject->identity($bool));
    }
}
