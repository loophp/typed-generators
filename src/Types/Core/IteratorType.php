<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\TypedGenerators\Types\Core;

use Iterator;
use loophp\TypedGenerators\Types\AbstractType;
use loophp\TypedGenerators\Types\Type;

/**
 * @template TKey
 * @template T
 *
 * @extends AbstractType<Iterator<TKey, T>>
 */
final class IteratorType extends AbstractType
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
     * @return Iterator<TKey, T>
     */
    public function __invoke(): Iterator
    {
        foreach (array_keys($this->keys) as $index) {
            yield ($this->keys[$index])() => ($this->values[$index])();
        }
    }

    /**
     * @template VKey of array-key
     * @template V
     *
     * @param Type<VKey> $key
     * @param Type<V> $value
     *
     * @return IteratorType<TKey|VKey, T|V>
     */
    public function add(Type $key, Type $value): IteratorType
    {
        // @TODO: See if we can fix this issue in PHPStan/PSalm.
        // There should not be @var annotation here.
        // An issue has been opened: https://github.com/vimeo/psalm/issues/8066
        /** @var IteratorType<TKey|VKey, T|V> $clone */
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
     * @param Iterator<TKey, T> $input
     *
     * @return Iterator<TKey, T>
     */
    public function identity($input): Iterator
    {
        return $input;
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
    public static function new(Type $key, Type $value): self
    {
        return new self($key, $value);
    }
}
