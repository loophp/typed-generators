<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\TypedGenerators\Types\Core;

use Closure;
use Iterator;
use loophp\TypedGenerators\Types\TypeGenerator;

/**
 * @implements TypeGenerator<Closure>
 */
final class ClosureType implements TypeGenerator
{
    public function __invoke()
    {
        return static fn () => true;
    }

    /**
     * @return Iterator<int, Closure>
     */
    public function getIterator(): Iterator
    {
        // @phpstan-ignore-next-line
        while (true) {
            yield $this->__invoke();
        }
    }

    /**
     * @param Closure $input
     */
    public function identity($input): Closure
    {
        return $input;
    }

    public static function new(): self
    {
        return new self();
    }
}
