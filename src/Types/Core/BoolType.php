<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\TypedGenerators\Types\Core;

use loophp\TypedGenerators\Types\AbstractTypeGenerator;

/**
 * @extends AbstractTypeGenerator<bool>
 */
final class BoolType extends AbstractTypeGenerator
{
    public function __invoke(): bool
    {
        return 0 === random_int(0, 1)
            ? true
            : false;
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
