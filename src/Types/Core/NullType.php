<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\TypedGenerators\Types\Core;

use loophp\TypedGenerators\Types\AbstractType;
use TypeError;

/**
 * @extends AbstractType<null>
 */
final class NullType extends AbstractType
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
