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

use const PHP_INT_MIN;

/**
 * @extends AbstractType<int>
 */
final class NegativeIntType extends AbstractType
{
    /**
     * @var Type<int>
     */
    private Type $type;

    public function __construct(int $min = PHP_INT_MIN)
    {
        $this->type = IntType::new($min, 0);
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

    public static function new(int $min = PHP_INT_MIN): self
    {
        return new self($min);
    }
}
