<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\generators\Types\Core;

use Closure;
use loophp\generators\Types\TypeGenerator;

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
