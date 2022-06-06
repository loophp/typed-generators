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
 * @implements TypeGenerator<bool>
 */
final class BoolType implements TypeGenerator
{
    public function __invoke(): bool
    {
        return 0 === random_int(0, 1)
            ? true
            : false;
    }

    /**
     * @return Iterator<int, bool>
     */
    public function getIterator(): Iterator
    {
        // @phpstan-ignore-next-line
        while (true) {
            yield $this->__invoke();
        }
    }

    /**
     * @param bool $input
     */
    public function identity($input): bool
    {
        return $input;
    }

    public static function new(): self
    {
        return new self();
    }
}
