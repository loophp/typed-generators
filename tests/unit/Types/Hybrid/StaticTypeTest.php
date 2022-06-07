<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace tests\loophp\TypedGenerators\Types\Hybrid;

use LimitIterator;
use loophp\TypedGenerators\Types\Core\StringType;
use loophp\TypedGenerators\Types\Hybrid\StaticType;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversDefaultClass \loophp\TypedGenerators
 */
final class StaticTypeTest extends TestCase
{
    public function testConstructor()
    {
        $subject = new StaticType(
            new StringType(),
            'foo'
        );

        self::assertEquals('foo', $subject());
    }

    public function testGetIterator()
    {
        $subject = new StaticType(new StringType(), 'foo');

        self::assertInstanceOf('Iterator', $subject->getIterator());

        $iterator = new LimitIterator($subject->getIterator(), 0, 3);

        $subject = iterator_to_array($iterator);
        self::assertCount(3, $subject);
        self::assertEquals(['foo', 'foo', 'foo'], $subject);
    }

    public function testIdentity()
    {
        $subject = new StaticType(new StringType(), 'bar');

        self::assertSame('bar', $subject->identity('bar'));
    }
}
