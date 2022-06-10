<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\TypedGenerators\Generator;

use IteratorAggregate;
use loophp\collection\Collection;
use loophp\collection\Contract\Collection as ContractCollection;
use loophp\TypedGenerators\Random\MT;
use loophp\TypedGenerators\Random\RandomInterface;
use loophp\TypedGenerators\TypeGeneratorFactory;
use Traversable;

final class TypeGenerator implements IteratorAggregate
{
    private ContractCollection $collection;

    private RandomInterface $random;

    private function __construct(ContractCollection $collection, ?RandomInterface $random = null)
    {
        $this->collection = $collection;
        $this->random = $random ?? new MT;
    }

    public function withRandom(RandomInterface $random): self
    {
        $clone = clone $this;
        $clone->random = $random;

        return $this;
    }

    public function getIterator(): Traversable {
        return $this->collection->getIterator();
    }

    public static function string(int $length = 5): self
    {
        return new self(
            Collection::fromIterable(TypeGeneratorFactory::string($length))
        );
    }

    public static function int(int $min = PHP_INT_MIN, int $max = PHP_INT_MAX): self
    {
        return new self(
            Collection::fromIterable(TypeGeneratorFactory::int($min, $max))
        );
    }

    public function map(callable $callable): self
    {
        return new self(
            $this->collection->map($callable)
        );
    }

    public function filter(callable $callable): self
    {
        return new self(
            $this->collection->filter($callable)
        );
    }

    public function take(int $count = 1000): self
    {
        return new self(
            $this->collection->limit($count)
        );
    }

    public static function choose(int $min, int $max): self
    {
        $random = new MT;

        return new self(
            Collection::unfold(
                fn(): array => [$random->one($min, $max)]
            )
            ->unwrap(),
            $random
        );
    }

}
