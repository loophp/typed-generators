<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace tests\loophp\TypedGenerators\Types\Hybrid;

use LimitIterator;
use loophp\TypedGenerators\Types\Hybrid\UniqidType;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversDefaultClass \loophp\TypedGenerators
 */
final class UniqidTypeTest extends TestCase
{
    public function testConstructor()
    {
        $subject = new UniqidType();

        self::assertIsString($subject());
    }

    public function testGetIterator()
    {
        $subject = new UniqidType();

        self::assertInstanceOf('Iterator', $subject->getIterator());

        $iterator = new LimitIterator($subject->getIterator(), 0, 3);

        $subject = iterator_to_array($iterator);
        self::assertCount(3, $subject);
    }

    public function testIdentity()
    {
        $subject = new UniqidType();

        self::assertSame('bar', $subject->identity('bar'));
    }
}
