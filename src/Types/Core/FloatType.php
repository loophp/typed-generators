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
 * @implements TypeGenerator<float>
 */
final class FloatType implements TypeGenerator
{
    public function __invoke(): float
    {
        return (float) (mt_rand() / mt_getrandmax());
    }

    /**
     * @return Iterator<int, float>
     */
    public function getIterator(): Iterator
    {
        // @phpstan-ignore-next-line
        while (true) {
            yield $this->__invoke();
        }
    }

    /**
     * @param float $input
     */
    public function identity($input): float
    {
        return $input;
    }

    public static function new(): self
    {
        return new self();
    }
}
