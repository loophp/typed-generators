<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\TypedGenerators\Types\Hybrid;

use Closure;
use Faker\Factory;
use Faker\Generator;
use loophp\TypedGenerators\Types\AbstractType;
use loophp\TypedGenerators\Types\Type;

/**
 * @template T
 *
 * @extends AbstractType<T>
 */
final class Faker extends AbstractType
{
    private Generator $faker;

    /**
     * @var Closure(Generator): T
     */
    private Closure $fakerGenerator;

    /**
     * @var Type<T>
     */
    private Type $type;

    /**
     * @param Type<T> $t
     * @param Closure(Generator): T $fakerGenerator
     */
    public function __construct(Type $t, Closure $fakerGenerator, ?Generator $faker = null)
    {
        $this->type = $t;
        $this->fakerGenerator = $fakerGenerator;
        $this->faker = $faker ?? Factory::create();
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

    /**
     * @template V
     *
     * @param Type<V> $type
     * @param Closure(Generator): V $fakerGenerator
     *
     * @return Faker<V>
     */
    public static function new(Type $type, Closure $fakerGenerator, ?Generator $faker = null): self
    {
        return new self($type, $fakerGenerator, $faker);
    }
}
