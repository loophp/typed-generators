<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace tests\loophp\TypedGenerators\Types\Core;

use LimitIterator;
use loophp\TypedGenerators\Types\Core\ArrayType;
use loophp\TypedGenerators\Types\Core\BoolType;
use loophp\TypedGenerators\Types\Core\ClosureType;
use loophp\TypedGenerators\Types\Core\DateTimeType;
use loophp\TypedGenerators\Types\Core\FloatType;
use loophp\TypedGenerators\Types\Core\IntType;
use loophp\TypedGenerators\Types\Core\IteratorType;
use loophp\TypedGenerators\Types\Core\ListType;
use loophp\TypedGenerators\Types\Core\NullType;
use loophp\TypedGenerators\Types\Core\ObjectType;
use loophp\TypedGenerators\Types\Core\StringType;
use loophp\TypedGenerators\Types\Hybrid\Nullable;
use loophp\TypedGenerators\Types\TypeGenerator;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversDefaultClass \loophp\TypedGenerators
 */
final class IteratorTest extends TestCase
{
    /**
     * @dataProvider typeProvider
     */
    public function testKeyValue(TypeGenerator $t1, TypeGenerator $t2)
    {
        $subject = IteratorType::new($t1, $t2);

        foreach (new LimitIterator($subject->getIterator(), 0, 3) as $iterator) {
            foreach (new LimitIterator($iterator, 0, 3) as $k => $v) {
                self::assertSame($k, $t1->identity($k));
                self::assertSame($v, $t2->identity($v));
            }
        }
    }

    public function typeProvider()
    {
        yield [
            new StringType(),
            new StringType(),
        ];

        yield [
            new ArrayType(new IntType(), new StringType()),
            new ArrayType(new IntType(), new StringType()),
        ];

        yield [
            new ListType(new StringType()),
            new ListType(new StringType()),
        ];

        yield [
            new BoolType(),
            new BoolType(),
        ];

        yield [
            new ClosureType(),
            new ClosureType(),
        ];

        yield [
            new DateTimeType(),
            new DateTimeType(),
        ];

        yield [
            new FloatType(),
            new FloatType(),
        ];

        yield [
            new IntType(),
            new IntType(),
        ];

        yield [
            new Nullable(new StringType()),
            new Nullable(new StringType()),
        ];

        yield [
            new NullType(),
            new NullType(),
        ];

        yield [
            new ObjectType(),
            new ObjectType(),
        ];
    }
}
