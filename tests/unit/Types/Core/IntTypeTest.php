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

/**
 * @internal
 * @coversDefaultClass \loophp\TypedGenerators
 */
final class IntTypeTest extends TestCase
{
    public function testConstructor()
    {
        self::assertIsInt((new IntType())());
    }

    public function testGetIterator()
    {
        $subject = new IntType();

        self::assertInstanceOf('Iterator', $subject->getIterator());

        $iterator = new LimitIterator($subject->getIterator(), 0, 3);

        self::assertCount(3, iterator_to_array($iterator));
    }
}
