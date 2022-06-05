<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\generators\Types\Core;

use loophp\generators\Types\TypeGenerator;
use TypeError;

/**
 * @implements TypeGenerator<null>
 */
final class NullType implements TypeGenerator
{
    public function __invoke()
    {
        return null;
    }

    /**
     * @param mixed $input
     *
     * @return null
     */
    public function identity($input)
    {
        if (null !== $input) {
            throw new TypeError('Invalid type');
        }

        return $input;
    }

    public static function new(): self
    {
        return new self();
    }
}
