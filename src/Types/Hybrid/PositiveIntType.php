<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\TypedGenerators\Types\Hybrid;

use loophp\TypedGenerators\Types\AbstractType;
use loophp\TypedGenerators\Types\Core\IntType;
use loophp\TypedGenerators\Types\Type;

use const PHP_INT_MAX;

/**
 * @extends AbstractType<int>
 */
final class PositiveIntType extends AbstractType
{
    /**
     * @var Type<int>
     */
    private Type $type;

    public function __construct(int $max = PHP_INT_MAX)
    {
        $this->type = IntType::new(0, $max);
    }

    public function __invoke(): int
    {
        return $this->type->__invoke();
    }

    /**
     * @param int $input
     */
    public function identity($input): int
    {
        return $input;
    }

    public static function new(int $max = PHP_INT_MAX): self
    {
        return new self($max);
    }
}
