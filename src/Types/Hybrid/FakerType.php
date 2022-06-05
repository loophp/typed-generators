<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\generators\Types\Hybrid;

use Closure;
use Faker\Factory;
use Faker\Generator;
use loophp\generators\Types\TypeGenerator;

/**
 * @template T
 *
 * @implements TypeGenerator<T>
 */
final class FakerType implements TypeGenerator
{
    private Generator $faker;

    /**
     * @var Closure(Generator): T
     */
    private Closure $fakerGenerator;

    /**
     * @var TypeGenerator<T>
     */
    private TypeGenerator $type;

    /**
     * @param TypeGenerator<T> $t
     * @param Closure(Generator): T $fakerGenerator
     */
    public function __construct(TypeGenerator $t, Closure $fakerGenerator, ?Generator $faker = null)
    {
        $this->type = $t;
        $this->fakerGenerator = $fakerGenerator;
        $this->faker = $faker ?? Factory::create();
    }

    /**
     * @param TypeGenerator<T> $t
     * @param Closure(Generator): T $fakerGenerator
     *
     * @return FakerType<T>
     */
    public static function new(TypeGenerator $t, Closure $fakerGenerator, ?Generator $faker = null): self
    {
        return new self($t, $fakerGenerator, $faker);
    }

    /**
     * @return T
     */
    public function __invoke()
    {
        return $this->identity(($this->fakerGenerator)($this->faker));
    }

    /**
     * @param T $input
     *
     * @return T
     */
    public function identity($input)
    {
        return $this->type->identity($input);
    }
}
