<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\TypedGenerators\Random;

interface RandomInterface
{
    public function one(int $min = 0, int $max = PHP_INT_MAX);

    public function pair(int $min = 0, int $max = PHP_INT_MAX): array;
}
