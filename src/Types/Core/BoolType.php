<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\TypedGenerators\Types\Core;

use Faker\Factory;
use Faker\Generator;
use loophp\TypedGenerators\Types\TypeGenerator;

/**
 * @implements TypeGenerator<bool>
 */
final class BoolType implements TypeGenerator
{
    private int $chanceOfGettingTrue;

    private Generator $faker;

    public function __construct(int $chanceOfGettingTrue = 50)
    {
        $this->faker = Factory::create();
        $this->chanceOfGettingTrue = $chanceOfGettingTrue;
    }

    public function __invoke(): bool
    {
        return $this->faker->boolean($this->chanceOfGettingTrue);
    }

    /**
     * @param bool $input
     */
    public function identity($input): bool
    {
        return $input;
    }

    public static function new(int $chanceOfGettingTrue = 50): self
    {
        return new self($chanceOfGettingTrue);
    }
}
