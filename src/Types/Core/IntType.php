<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\TypedGenerators\Types\Core;

use loophp\TypedGenerators\Types\TypeGenerator;

/**
 * @implements TypeGenerator<int>
 */
final class IntType implements TypeGenerator
{
    private int $length;

    public function __construct(int $length = 1)
    {
        $this->length = $length;
    }

    public function __invoke(): int
    {
        return (int) implode(
            '',
            array_map(
                static fn (int $value): int => mt_rand(1 === $value ? 1 : 0, 9),
                range(1, $this->length)
            )
        );
    }

    /**
     * @param int $input
     */
    public function identity($input): int
    {
        return $input;
    }

    public static function new(int $length = 1): self
    {
        return new self($length);
    }
}
