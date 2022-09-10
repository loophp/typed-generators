<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\TypedGenerators\Types\Core;

use loophp\TypedGenerators\Types\AbstractType;
use loophp\TypedGenerators\Types\Type;

use function array_key_exists;
use function count;

/**
 * @template TKey of array-key
 * @template T
 *
 * @extends AbstractType<array<TKey, T>>
 */
final class ArrayType extends AbstractType
{
    /**
     * @var list<Type<TKey>>
     */
    private array $keys = [];

    /**
     * @var list<Type<T>>
     */
    private array $values = [];

    /**
     * @param Type<TKey> $key
     * @param Type<T> $value
     */
    public function __construct(Type $key, Type $value)
    {
        $this->keys[] = $key;
        $this->values[] = $value;
    }

    /**
     * @return array<TKey, T>
     */
    public function __invoke(): array
    {
        $keys = [];
        $countKeys = count($this->keys);

        // TODO: What is doing this thing??
        for ($i = 0; count($keys) < $countKeys; ++$i) {
            $key = ($this->keys[$i])();

            if (array_key_exists($key, $keys)) {
                --$i;

                continue;
            }

            $keys[$key] = $key;
        }

        return array_combine(
            $keys,
            array_map(
                /**
                 * @param Type<T> $value
                 *
                 * @return T
                 */
                static fn (Type $value) => $value(),
                $this->values
            )
        );
    }

    /**
     * @template VKey of array-key
     * @template V
     *
     * @param Type<VKey> $key
     * @param Type<V> $value
     *
     * @return ArrayType<TKey|VKey, T|V>
     */
    public function add(Type $key, Type $value): ArrayType
    {
        // @TODO: See if we can fix this issue in PHPStan/PSalm.
        // There should not be @var annotation here.
        // An issue has been opened: https://github.com/vimeo/psalm/issues/8066
        /** @var ArrayType<TKey|VKey, T|V> $clone */
        $clone = clone $this;

        /** @var list<Type<TKey|VKey>> $keys */
        $keys = array_merge($this->keys, [$key]);
        $clone->keys = $keys;

        /** @var list<Type<T|V>> $values */
        $values = array_merge($this->values, [$value]);
        $clone->values = $values;

        return $clone;
    }

    /**
     * @param array<TKey, T> $input
     *
     * @return array<TKey, T>
     */
    public function identity($input): array
    {
        return $input;
    }

    /**
     * @template WKey of array-key
     * @template W
     *
     * @param Type<WKey> $key
     * @param Type<W> $value
     *
     * @return ArrayType<WKey, W>
     */
    public static function new(Type $key, Type $value): self
    {
        return new self($key, $value);
    }
}
