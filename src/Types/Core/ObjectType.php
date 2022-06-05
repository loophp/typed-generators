<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\TypedGenerators\Types\Core;

use loophp\TypedGenerators\Types\TypeGenerator;
use stdClass;

/**
 * @implements TypeGenerator<object>
 */
final class ObjectType implements TypeGenerator
{
    public function __invoke(): object
    {
        return new stdClass();
    }

    /**
     * @param object $input
     */
    public function identity($input): object
    {
        return $input;
    }

    public static function new(): self
    {
        return new self();
    }
}
