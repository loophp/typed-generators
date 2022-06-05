<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\TypedGenerators\Types;

/**
 * @template T
 */
interface TypeGenerator
{
    /**
     * @return T
     */
    public function __invoke();

    /**
     * @param T $input
     *
     * @return T
     */
    public function identity($input);
}
