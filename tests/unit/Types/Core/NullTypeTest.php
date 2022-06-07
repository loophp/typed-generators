<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace tests\loophp\TypedGenerators\Types\Core;

use LimitIterator;
use loophp\TypedGenerators\Types\Core\NullType;
use PHPUnit\Framework\TestCase;
use TypeError;

/**
 * @internal
 * @coversDefaultClass \loophp\TypedGenerators
 */
final class NullTypeTest extends TestCase
{
    public function testGetIterator()
    {
        $subject = new NullType();

        self::assertInstanceOf('Iterator', $subject->getIterator());

        $iterator = new LimitIterator($subject->getIterator(), 0, 3);

        self::assertCount(3, iterator_to_array($iterator));
    }

    public function testIdentity()
    {
        $subject = new NullType();

        self::assertNull($subject->identity(null));

        self::expectException(TypeError::class);

        $subject->identity('foo');
    }
}
