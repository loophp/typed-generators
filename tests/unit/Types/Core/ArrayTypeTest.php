<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace tests\loophp\TypedGenerators\Types\Core;

use LimitIterator;
use loophp\TypedGenerators\Types\Core\ArrayType;
use loophp\TypedGenerators\Types\Core\IntType;
use loophp\TypedGenerators\Types\Core\StringType;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversDefaultClass \loophp\TypedGenerators
 */
final class ArrayTypeTest extends TestCase
{
    public function testGetIterator()
    {
        $subject = new ArrayType(new StringType(), new StringType());

        self::assertInstanceOf('Iterator', $subject->getIterator());

        $iterator = new LimitIterator($subject->getIterator(), 0, 3);

        self::assertCount(3, iterator_to_array($iterator));
    }

    public function testInvoke()
    {
        $subject = ArrayType::new(IntType::new(), IntType::new())
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
