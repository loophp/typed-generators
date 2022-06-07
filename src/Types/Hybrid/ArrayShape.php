<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\TypedGenerators\Types\Hybrid;

use Iterator;
use loophp\TypedGenerators\Types\TypeGenerator;

use function array_key_exists;
use function count;

/**
 * @immutable
 *
 * @template TKey of array-key
 * @template T
 *
 * @implements TypeGenerator<array<TKey, T>>
 */
final class ArrayShape implements TypeGenerator
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
     *
     * @return ArrayShape<TKey, T>
     */
    public function __construct(TypeGenerator $key, TypeGenerator $value)
    {
        $this->keys[] = $key;
        $this->values[] = $value;
    }

    /**
     * @return array<TKey, T>
     */
    public function __invoke(): array
    {
        $keys = $values = [];
        $countKeys = count($this->keys);

        for ($i = 0; count($keys) < $countKeys; ++$i) {
            $key = ($this->keys[$i])();

            if (array_key_exists($key, $keys)) {
                --$i;

                continue;
            }

            $keys[$key] = $key;
        }

        foreach ($this->values as $value) {
            $values[] = ($value)();
        }

        return array_combine($keys, $values);
    }

    /**
     * @template VKey of array-key
     * @template V
     *
     * @param TypeGenerator<VKey> $key
     * @param TypeGenerator<V> $value
     *
     * @return ArrayShape<TKey|VKey, T|V>
     */
    public function add(TypeGenerator $key, TypeGenerator $value): ArrayShape
    {
        // @TODO: See if we can fix this issue in PHPStan/PSalm.
        // There should not be @var annotation here.
        // An issue has been opened: https://github.com/vimeo/psalm/issues/8066
        /** @var ArrayShape<TKey|VKey, T|V> $clone */
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
     * @return Iterator<int, array<TKey, T>>
     */
    public function getIterator(): Iterator
    {
        // @phpstan-ignore-next-line
        while (true) {
            yield $this->__invoke();
        }
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
     * @param TypeGenerator<WKey> $key
     * @param TypeGenerator<W> $value
     *
     * @return ArrayShape<WKey, W>
     */
    public static function new(TypeGenerator $key, TypeGenerator $value): self
    {
        return new self($key, $value);
    }
}
