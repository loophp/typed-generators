<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\TypedGenerators;

use Closure;
use DateTimeInterface;
use Faker\Generator;
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
use loophp\TypedGenerators\Types\Hybrid\Faker;
use loophp\TypedGenerators\Types\Hybrid\Nullable;
use loophp\TypedGenerators\Types\TypeGenerator;

final class TypedGen
{
    /**
     * @template WKey of array-key
     * @template W
     *
     * @param TypeGenerator<WKey> $key
     * @param TypeGenerator<W> $value
     *
     * @return ArrayType<WKey, W>
     */
    public static function array(TypeGenerator $key, TypeGenerator $value, int $count = 1): ArrayType
    {
        return ArrayType::new($key, $value, $count);
    }

    public static function bool(): BoolType
    {
        return BoolType::new();
    }

    public static function closure(): ClosureType
    {
        return ClosureType::new();
    }

    /**
     * @template V
     * @template W
     *
     * @param TypeGenerator<V> $t1
     * @param TypeGenerator<W> $t2
     *
     * @return Compound<V, W>
     */
    public static function compound(TypeGenerator $t1, TypeGenerator $t2): Compound
    {
        return Compound::new($t1, $t2);
    }

    public static function datetime(?DateTimeInterface $from = null, ?DateTimeInterface $to = null): DateTimeType
    {
        return DateTimeType::new($from, $to);
    }

    /**
     * @template V
     *
     * @param TypeGenerator<V> $type
     * @param Closure(Generator): V $fakerGenerator
     *
     * @return Faker<V>
     */
    public static function faker(TypeGenerator $type, Closure $fakerGenerator, ?Generator $faker = null): Faker
    {
        return Faker::new($type, $fakerGenerator, $faker);
    }

    public static function float(): FloatType
    {
        return FloatType::new();
    }

    public static function int(): IntType
    {
        return IntType::new();
    }

    /**
     * @template WKey
     * @template W
     *
     * @param TypeGenerator<WKey> $key
     * @param TypeGenerator<W> $value
     *
     * @return IteratorType<WKey, W>
     */
    public static function iterator(TypeGenerator $key, TypeGenerator $value): IteratorType
    {
        return IteratorType::new($key, $value);
    }

    /**
     * @template W
     *
     * @param TypeGenerator<W> $type
     *
     * @return ListType<W>
     */
    public static function list(TypeGenerator $type): ListType
    {
        return ListType::new($type);
    }

    public static function null(): NullType
    {
        return NullType::new();
    }

    /**
     * @template W
     *
     * @param TypeGenerator<W> $type
     *
     * @return Nullable<W>
     */
    public static function nullable(TypeGenerator $type): Nullable
    {
        return Nullable::new($type);
    }

    public static function object(): ObjectType
    {
        return ObjectType::new();
    }

    public static function string(int $length = 1): StringType
    {
        return StringType::new($length);
    }
}
