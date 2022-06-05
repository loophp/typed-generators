<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\TypedGenerators\Generator;

use Generator;
use loophp\TypedGenerators\Types\TypeGenerator;

/**
 * @template TKey
 * @template T
 *
 * @implements TypedGenerator<TKey, T>
 */
final class KeyValue implements TypedGenerator
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
     * @return Generator<TKey, T>
     */
    public function getIterator(): Generator
    {
        // @phpstan-ignore-next-line
        while (true) {
            yield ($this->key)() => ($this->value)();
        }
    }

    /**
     * @template WKey
     * @template W
     *
     * @param TypeGenerator<WKey> $k
     * @param TypeGenerator<W> $v
     *
     * @return KeyValue<WKey, W>
     */
    public static function new(TypeGenerator $k, TypeGenerator $v): self
    {
        return new self($k, $v);
    }
}
