<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\TypedGenerators\Random;

final class MT implements RandomInterface
{
    private int $seed = 0;
    private int $mode = MT_RAND_MT19937;

    public function withSeed(int $seed): self
    {
        $clone = clone $this;
        $clone->seed = $seed;

        mt_srand($this->seed);

        return $clone;
    }

    public function one(int $min = 0, int $max = PHP_INT_MAX): int
    {
        return mt_rand($min, $max);
    }

    public function pair(int $min = 0, int $max = PHP_INT_MAX): array
    {
        return [mt_rand($min, $max), mt_rand($min, $max)];
    }
}
