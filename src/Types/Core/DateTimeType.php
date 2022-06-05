<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\TypedGenerators\Types\Core;

use DateTimeImmutable;
use DateTimeInterface;
use loophp\TypedGenerators\Types\TypeGenerator;

/**
 * @implements TypeGenerator<DateTimeInterface>
 */
final class DateTimeType implements TypeGenerator
{
    private DateTimeInterface $end;

    private DateTimeInterface $start;

    public function __construct(?DateTimeInterface $start = null, ?DateTimeInterface $end = null)
    {
        $this->start = $start ?? new DateTimeImmutable(date('Y-m-d', mt_rand(1, time())));
        $this->end = $end ?? new DateTimeImmutable();
    }

    public function __invoke(): DateTimeInterface
    {
        $randomDate = new DateTimeImmutable();

        return $randomDate
            ->setTimestamp(
                mt_rand(
                    $this->start->getTimestamp(),
                    $this->end->getTimestamp()
                )
            );
    }

    /**
     * @param DateTimeInterface $input
     */
    public function identity($input): DateTimeInterface
    {
        return $input;
    }

    public static function new(?DateTimeInterface $start = null, ?DateTimeInterface $end = null): self
    {
        return new self($start, $end);
    }
}
