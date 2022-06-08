<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\TypedGenerators\Types\Core;

use Iterator;
use loophp\TypedGenerators\Types\AbstractTypeGenerator;
use loophp\TypedGenerators\Types\TypeGenerator;

/**
 * @template TKey
 * @template T
 *
 * @extends AbstractTypeGenerator<Iterator<TKey, T>>
 */
final class IteratorType extends AbstractTypeGenerator
{
    /**
     * @var list<TypeGenerator<TKey>>
     */
    private array $keys = [];

    /**
     * @var list<TypeGenerator<T>>
     */
    private array $values = [];

    /**
     * @param TypeGenerator<TKey> $key
     * @param TypeGenerator<T> $value
     */
    public function __construct(TypeGenerator $key, TypeGenerator $value)
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
     * @param TypeGenerator<VKey> $key
     * @param TypeGenerator<V> $value
     *
     * @return IteratorType<TKey|VKey, T|V>
     */
    public function add(TypeGenerator $key, TypeGenerator $value): IteratorType
    {
        // @TODO: See if we can fix this issue in PHPStan/PSalm.
        // There should not be @var annotation here.
        // An issue has been opened: https://github.com/vimeo/psalm/issues/8066
        /** @var IteratorType<TKey|VKey, T|V> $clone */
        $clone = clone $this;

        /** @var list<TypeGenerator<TKey|VKey>> $keys */
        $keys = array_merge($this->keys, [$key]);
        $clone->keys = $keys;

        /** @var list<TypeGenerator<T|V>> $values */
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
     * @param TypeGenerator<WKey> $key
     * @param TypeGenerator<W> $value
     *
     * @return IteratorType<WKey, W>
     */
    public static function new(TypeGenerator $key, TypeGenerator $value): self
    {
        return new self($key, $value);
    }
}
