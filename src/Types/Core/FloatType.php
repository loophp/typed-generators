<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\TypedGenerators\Types\Core;

use loophp\TypedGenerators\Types\AbstractType;

/**
 * @extends AbstractType<float>
 */
final class FloatType extends AbstractType
{
    public function __invoke(): float
    {
        return (float) (BoolType::new()() ? -1 : 1) * (mt_rand() / mt_getrandmax());
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
