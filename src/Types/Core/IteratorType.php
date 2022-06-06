<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\TypedGenerators\Types\Core;

use Iterator;
use loophp\TypedGenerators\Types\TypeGenerator;

/**
 * @template TKey
 * @template T
 *
 * @implements TypeGenerator<Iterator<TKey, T>>
 */
final class IteratorType implements TypeGenerator
{
    /**
     * @var TypeGenerator<TKey>
     */
    private TypeGenerator $key;

    /**
     * @var TypeGenerator<T>
     */
    private TypeGenerator $value;

    /**
     * @param TypeGenerator<TKey> $k
     * @param TypeGenerator<T> $v
     */
    public function __construct(TypeGenerator $k, TypeGenerator $v)
    {
        $this->key = $k;
        $this->value = $v;
    }

    /**
     * @return Iterator<TKey, T>
     */
    public function __invoke(): Iterator
    {
        // @phpstan-ignore-next-line
        while (true) {
            yield ($this->key)() => ($this->value)();
        }
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
     * @param TypeGenerator<WKey> $k
     * @param TypeGenerator<W> $v
     *
     * @return IteratorType<WKey, W>
     */
    public static function new(TypeGenerator $k, TypeGenerator $v): self
    {
        return new self($k, $v);
    }
}
