<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\TypedGenerators\Types\Core;

use Closure;
use loophp\TypedGenerators\Types\AbstractType;

/**
 * @extends AbstractType<Closure>
 */
final class ClosureType extends AbstractType
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
