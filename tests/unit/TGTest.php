<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace tests\loophp\TypedGenerators;

use Faker\Generator;
use loophp\TypedGenerators\TG;
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
use loophp\TypedGenerators\Types\Hybrid\Compound;
use loophp\TypedGenerators\Types\Hybrid\Custom;
use loophp\TypedGenerators\Types\Hybrid\Faker;
use loophp\TypedGenerators\Types\Hybrid\Nullable;
use loophp\TypedGenerators\Types\Hybrid\StaticType;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversDefaultClass \loophp\TypedGenerators
 */
final class TGTest extends TestCase
{
    /**
     * @dataProvider typeProvider
     */
    public function testStaticFactories(string $method, array $arguments, string $class)
    {
        self::assertInstanceOf($class, TG::{$method}(...$arguments));
    }

    public function typeProvider()
    {
        yield [
            'method' => 'array',
            'arguments' => [
                new StringType(),
                new StringType(),
            ],
            'class' => ArrayType::class,
        ];

        yield [
            'method' => 'bool',
            'arguments' => [],
            'class' => BoolType::class,
        ];

        yield [
            'method' => 'closure',
            'arguments' => [],
            'class' => ClosureType::class,
        ];

        yield [
            'method' => 'compound',
            'arguments' => [
                new StringType(),
                new IntType(),
            ],
            'class' => Compound::class,
        ];

        yield [
            'method' => 'custom',
            'arguments' => [
                new StringType(),
                static fn (): string => 'hello',
            ],
            'class' => Custom::class,
        ];

        yield [
            'method' => 'datetime',
            'arguments' => [],
            'class' => DateTimeType::class,
        ];

        yield [
            'method' => 'faker',
            'arguments' => [
                new StringType(),
                static fn (Generator $faker): string => $faker->city(),
            ],
            'class' => Faker::class,
        ];

        yield [
            'method' => 'float',
            'arguments' => [],
            'class' => FloatType::class,
        ];

        yield [
            'method' => 'int',
            'arguments' => [],
            'class' => IntType::class,
        ];

        yield [
            'method' => 'iterator',
            'arguments' => [
                new StringType(),
                new IntType(),
            ],
            'class' => IteratorType::class,
        ];

        yield [
            'method' => 'list',
            'arguments' => [
                new StringType(),
            ],
            'class' => ListType::class,
        ];

        yield [
            'method' => 'null',
            'arguments' => [],
            'class' => NullType::class,
        ];

        yield [
            'method' => 'nullable',
            'arguments' => [
                new StringType(),
            ],
            'class' => Nullable::class,
        ];

        yield [
            'method' => 'object',
            'arguments' => [],
            'class' => ObjectType::class,
        ];

        yield [
            'method' => 'static',
            'arguments' => [
                new StringType(),
                'foo',
            ],
            'class' => StaticType::class,
        ];

        yield [
            'method' => 'string',
            'arguments' => [],
            'class' => StringType::class,
        ];
    }
}
