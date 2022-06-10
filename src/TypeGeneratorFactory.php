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
use loophp\TypedGenerators\Types\Hybrid\ArrayKeyType;
use loophp\TypedGenerators\Types\Hybrid\Compound;
use loophp\TypedGenerators\Types\Hybrid\Custom;
use loophp\TypedGenerators\Types\Hybrid\Faker;
use loophp\TypedGenerators\Types\Hybrid\NegativeIntType;
use loophp\TypedGenerators\Types\Hybrid\Nullable;
use loophp\TypedGenerators\Types\Hybrid\NumericType;
use loophp\TypedGenerators\Types\Hybrid\PositiveIntType;
use loophp\TypedGenerators\Types\Hybrid\StaticType;
use loophp\TypedGenerators\Types\Hybrid\UniqidType;
use loophp\TypedGenerators\Types\Type;

use const PHP_INT_MAX;
use const PHP_INT_MIN;

final class TypeGeneratorFactory
{
    /**
     * @template WKey of array-key
     * @template W
     *
     * @param Type<WKey> $key
     * @param Type<W> $value
     *
     * @return ArrayType<WKey, W>
     */
    public static function array(Type $key, Type $value): ArrayType
    {
        return ArrayType::new($key, $value);
    }

    public static function arrayKey(): ArrayKeyType
    {
        return ArrayKeyType::new();
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
     * @param Type<V> $t1
     * @param Type<W> $t2
     *
     * @return Compound<V, W>
     */
    public static function compound(Type $t1, Type $t2): Compound
    {
        return Compound::new($t1, $t2);
    }

    /**
     * @template V
     *
     * @param Type<V> $type
     * @param Closure(Type<V>): V $generator
     *
     * @return Custom<V>
     */
    public static function custom(Type $type, Closure $generator): Custom
    {
        return Custom::new($type, $generator);
    }

    public static function datetime(?DateTimeInterface $from = null, ?DateTimeInterface $to = null): DateTimeType
    {
        return DateTimeType::new($from, $to);
    }

    /**
     * @template V
     *
     * @param Type<V> $type
     * @param Closure(Generator): V $fakerGenerator
     *
     * @return Faker<V>
     */
    public static function faker(Type $type, Closure $fakerGenerator, ?Generator $faker = null): Faker
    {
        return Faker::new($type, $fakerGenerator, $faker);
    }

    public static function float(): FloatType
    {
        return FloatType::new();
    }

    public static function int(int $length = 1): IntType
    {
        return IntType::new($length);
    }

    /**
     * @template WKey
     * @template W
     *
     * @param Type<WKey> $key
     * @param Type<W> $value
     *
     * @return IteratorType<WKey, W>
     */
    public static function iterator(Type $key, Type $value): IteratorType
    {
        return IteratorType::new($key, $value);
    }

    /**
     * @template W
     *
     * @param Type<W> $type
     *
     * @return ListType<W>
     */
    public static function list(Type $type): ListType
    {
        return ListType::new($type);
    }

    public static function negativeInt(int $min = PHP_INT_MIN): NegativeIntType
    {
        return NegativeIntType::new($min);
    }

    public static function null(): NullType
    {
        return NullType::new();
    }

    /**
     * @template W
     *
     * @param Type<W> $type
     *
     * @return Nullable<W>
     */
    public static function nullable(Type $type): Nullable
    {
        return Nullable::new($type);
    }

    public static function numeric(): NumericType
    {
        return NumericType::new();
    }

    public static function object(): ObjectType
    {
        return ObjectType::new();
    }

    public static function positiveInt(int $max = PHP_INT_MAX): PositiveIntType
    {
        return PositiveIntType::new($max);
    }

    /**
     * @template W
     *
     * @param Type<W> $type
     * @param W $value
     *
     * @return StaticType<W>
     */
    public static function static(Type $type, $value): StaticType
    {
        return StaticType::new($type, $value);
    }

    public static function string(int $length = 1): StringType
    {
        return StringType::new($length);
    }

    public static function uniqid(string $prefix = '', bool $moreEntropy = false): UniqidType
    {
        return UniqidType::new($prefix, $moreEntropy);
    }
}
