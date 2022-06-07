<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace tests\loophp\TypedGenerators\Types\Hybrid;

use LimitIterator;
use loophp\TypedGenerators\Types\Core\BoolType;
use loophp\TypedGenerators\Types\Hybrid\Custom;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversDefaultClass \loophp\TypedGenerators
 */
final class CustomTest extends TestCase
{
    public function testConstructor()
    {
        $subject = new Custom(
            new BoolType(),
            static fn (): bool => true
        );

        self::assertIsBool($subject());
    }

    public function testGetIterator()
    {
        $subject = new Custom(new BoolType(), static fn (): bool => true);

        self::assertInstanceOf('Iterator', $subject->getIterator());

        $iterator = new LimitIterator($subject->getIterator(), 0, 3);

        self::assertCount(3, iterator_to_array($iterator));
    }

    public function testIdentity()
    {
        $subject = new Custom(new BoolType(), static fn (): bool => true);

        self::assertTrue($subject->identity(true));
    }
}
