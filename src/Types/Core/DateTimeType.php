<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\TypedGenerators\Types\Core;

use DateTimeImmutable;
use DateTimeInterface;
use loophp\TypedGenerators\Types\AbstractType;

/**
 * @extends AbstractType<DateTimeInterface>
 */
final class DateTimeType extends AbstractType
{
    private DateTimeInterface $end;

    private DateTimeInterface $start;

    public function __construct(?DateTimeInterface $start = null, ?DateTimeInterface $end = null)
    {
        $this->start = $start ?? new DateTimeImmutable(date('Y-m-d', random_int(1, time())));
        $this->end = $end ?? new DateTimeImmutable();
    }

    public function __invoke(): DateTimeInterface
    {
        $randomDate = new DateTimeImmutable();

        return $randomDate
            ->setTimestamp(
                random_int(
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
