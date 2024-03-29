<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\TypedGenerators\Types\Core;

use loophp\TypedGenerators\Types\AbstractType;

use const PHP_INT_MAX;
use const PHP_INT_MIN;

/**
 * @extends AbstractType<int>
 */
final class IntType extends AbstractType
{
    public function __construct(private int $min = PHP_INT_MIN, private int $max = PHP_INT_MAX)
    {
    }

    public function __invoke(): int
    {
        return random_int($this->min, $this->max);
    }

    /**
     * @param int $input
     */
    public function identity($input): int
    {
        return $input;
    }

    public static function new(int $min = PHP_INT_MIN, int $max = PHP_INT_MAX): self
    {
        return new self($min, $max);
    }
}
