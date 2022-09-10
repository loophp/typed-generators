<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace tests\loophp\TypedGenerators\Types\Core;

use LimitIterator;
use loophp\TypedGenerators\Types\Core\IntType;
use loophp\TypedGenerators\Types\Core\ListType;
use loophp\TypedGenerators\Types\Core\StringType;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversDefaultClass \loophp\TypedGenerators
 */
final class ListTypeTest extends TestCase
{
    public function testGetIterator()
    {
        $subject = new ListType(new StringType());

        self::assertInstanceOf('Iterator', $subject->getIterator());

        $iterator = new LimitIterator($subject->getIterator(), 0, 3);

        self::assertCount(3, iterator_to_array($iterator));
    }

    public function testInvoke()
    {
        $subject = ListType::new(IntType::new())
            ->add(IntType::new())
            ->add(IntType::new())
            ->add(IntType::new())
            ->add(IntType::new())
            ->add(IntType::new())
            ->add(IntType::new())
            ->add(IntType::new())
            ->add(IntType::new())
            ->add(IntType::new());

        self::assertCount(10, $subject());
    }
}
