<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\generators\Types\Core;

use loophp\generators\Types\TypeGenerator;

/**
 * @implements TypeGenerator<array>
 */
final class ArrayType implements TypeGenerator
{
    /**
     * @return array<array-key, mixed>
     */
    public function __invoke(): array
    {
        return [];
    }

    /**
     * @param array<array-key, mixed> $input
     *
     * @return array<array-key, mixed>
     */
    public function identity($input): array
    {
        return $input;
    }

    public static function new(): self
    {
        return new self();
    }
}
