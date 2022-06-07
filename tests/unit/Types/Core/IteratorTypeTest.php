<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace tests\loophp\TypedGenerators\Types\Core;

use LimitIterator;
use loophp\TypedGenerators\Types\Core\IntType;
use loophp\TypedGenerators\Types\Core\IteratorType;
use loophp\TypedGenerators\Types\Core\StringType;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversDefaultClass \loophp\TypedGenerators
 */
final class IteratorTypeTest extends TestCase
{
    public function testGetIterator()
    {
        $subject = new IteratorType(new StringType(), new StringType());

        self::assertInstanceOf('Iterator', $subject->getIterator());

        $iterator = new LimitIterator($subject->getIterator(), 0, 3);

        self::assertCount(3, iterator_to_array($iterator));
    }

    public function testInvoke()
    {
        $subject = IteratorType::new(IntType::new(), IntType::new())
            ->add(IntType::new(), IntType::new())
            ->add(IntType::new(), IntType::new())
            ->add(IntType::new(), IntType::new())
            ->add(IntType::new(), IntType::new())
            ->add(IntType::new(), IntType::new())
            ->add(IntType::new(), IntType::new())
            ->add(IntType::new(), IntType::new())
            ->add(IntType::new(), IntType::new())
            ->add(IntType::new(), IntType::new());

        self::assertCount(10, $subject());
    }
}
