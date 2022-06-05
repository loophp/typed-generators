<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace tests\loophp\generators;

use LimitIterator;
use loophp\generators\Generator\Value;
use loophp\generators\Types\Core\ArrayType;
use loophp\generators\Types\Core\BoolType;
use loophp\generators\Types\Core\ClosureType;
use loophp\generators\Types\Core\DateTimeType;
use loophp\generators\Types\Core\FloatType;
use loophp\generators\Types\Core\IntType;
use loophp\generators\Types\Core\NullType;
use loophp\generators\Types\Core\ObjectType;
use loophp\generators\Types\Core\StringType;
use loophp\generators\Types\TypeGenerator;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversDefaultClass \loophp\generators
 */
final class ValueTest extends TestCase
{
    /**
     * @dataProvider typeProvider
     */
    public function testKeyValue(TypeGenerator $t1)
    {
        $subject = Value::new($t1);

        foreach (new LimitIterator($subject->getIterator(), 0, 3) as $k => $v) {
            self::assertSame($k, IntType::new()->identity($k));
            self::assertSame($v, $t1->identity($v));
        }
    }

    public function typeProvider()
    {
        yield [
            new StringType(),
        ];

        yield [
            new ArrayType(),
        ];

        yield [
            new BoolType(),
        ];

        yield [
            new ClosureType(),
        ];

        yield [
            new DateTimeType(),
        ];

        yield [
            new FloatType(),
        ];

        yield [
            new IntType(),
        ];

        yield [
            new NullType(),
        ];

        yield [
            new ObjectType(),
        ];
    }
}
