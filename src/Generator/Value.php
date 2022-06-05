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
 * @template T
 *
 * @implements TypedGenerator<int, T>
 */
final class Value implements TypedGenerator
{
    /**
     * @var TypeGenerator<T>
     */
    private TypeGenerator $value;

    /**
     * @param TypeGenerator<T> $t
     */
    public function __construct(TypeGenerator $t)
    {
        $this->value = $t;
    }

    /**
     * @return Generator<int, T>
     */
    public function getIterator(): Generator
    {
        // @phpstan-ignore-next-line
        while (true) {
            yield ($this->value)();
        }
    }

    /**
     * @template W
     *
     * @param TypeGenerator<W> $t
     *
     * @return Value<W>
     */
    public static function new(TypeGenerator $t): self
    {
        return new self($t);
    }
}
