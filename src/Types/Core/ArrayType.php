<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\generators\Types\Core;

use loophp\generators\Types\TypeGenerator;

use function count;

/**
 * @template TKey
 * @template T
 *
 * @implements TypeGenerator<array<TKey, T>>
 */
final class ArrayType implements TypeGenerator
{
    private int $count;

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
    public function __construct(TypeGenerator $k, TypeGenerator $v, int $count = 1)
    {
        $this->key = $k;
        $this->value = $v;
        $this->count = $count;
    }

    /**
     * @return array<TKey, T>
     */
    public function __invoke(): array
    {
        $return = [];

        while (count($return) < $this->count) {
            $return[($this->key)()] = ($this->value)();
        }

        return $return;
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
     * @template WKey
     * @template W
     *
     * @param TypeGenerator<WKey> $k
     * @param TypeGenerator<W> $v
     *
     * @return ArrayType<WKey, W>
     */
    public static function new(TypeGenerator $k, TypeGenerator $v, int $count = 1): self
    {
        return new self($k, $v, $count);
    }
}
