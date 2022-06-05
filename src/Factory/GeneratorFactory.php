<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\generators\Factory;

use Closure;
use Exception;
use Generator;
use LimitIterator;
use loophp\generators\Generator\KeyValue;
use loophp\generators\Generator\TypedGenerator;
use loophp\generators\Generator\Value;
use loophp\generators\Types\TypeGenerator;

/**
 * @template TKey
 * @template T
 */
final class GeneratorFactory
{
    /**
     * @var TypedGenerator<int, T>|TypedGenerator<TKey, T>
     */
    private ?TypedGenerator $generator = null;

    /**
     * @var (Closure(TypedGenerator<int, T>): Generator<int, T>)|(Closure(TypedGenerator<TKey, T>): Generator<TKey, T>)
     */
    private ?Closure $wrapper = null;

    /**
     * @return Generator<int, T>|Generator<TKey, T>
     */
    public function __invoke(): Generator
    {
        if (null === $this->wrapper) {
            throw new Exception('Error');
        }

        if (null === $this->generator) {
            throw new Exception('Error');
        }

        yield from ($this->wrapper)($this->generator);
    }

    /**
     * @return GeneratorFactory<TKey, T>|GeneratorFactory<int, T>
     */
    public function infinite(): self
    {
        $this->wrapper =
            /**
             * @param TypedGenerator<TKey, T>|TypedGenerator<int, T> $typedGenerator
             *
             * @return ($typedGenerator is TypedGenerator<TKey, T> ? Generator<TKey, T> : Generator<int, T>)
             */
            static fn (TypedGenerator $typedGenerator): Generator => $typedGenerator();

        return $this;
    }

    /**
     * @param TypeGenerator<TKey> $k
     * @param TypeGenerator<T> $v
     *
     * @return GeneratorFactory<TKey, T>
     */
    public function keyValueOf(TypeGenerator $k, TypeGenerator $v): self
    {
        /** @var TypedGenerator<TKey, T> $generator */
        $generator = new KeyValue($k, $v);

        $this->generator = $generator;

        return $this;
    }

    /**
     * @param TypeGenerator<T> $t
     *
     * @return GeneratorFactory<int, T>
     */
    public function listOf(TypeGenerator $t): self
    {
        /** @var TypedGenerator<int, T> $generator */
        $generator = new Value($t);

        $this->generator = $generator;

        return $this;
    }

    public static function new(): self
    {
        return new self();
    }

    /**
     * @return GeneratorFactory<TKey, T>|GeneratorFactory<int, T>
     */
    public function some(int $size = 10): self
    {
        $this->wrapper =
            /**
             * @param TypedGenerator<TKey, T>|TypedGenerator<int, T> $typedGenerator
             *
             * @return ($typedGenerator is TypedGenerator<TKey, T> ? Generator<TKey, T> : Generator<int, T>)
             */
            static fn (TypedGenerator $typedGenerator): Generator => yield from new LimitIterator(
                $typedGenerator(),
                0,
                $size
            );

        return $this;
    }
}
