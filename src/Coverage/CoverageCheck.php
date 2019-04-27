<?php

declare(strict_types=1);

namespace CoverageChecker\Coverage;

use function str_pad;
use const STR_PAD_LEFT;

final class CoverageCheck
{
    /**
     * @var NamespacePart
     */
    private $namespacePart;

    /**
     * @var int
     */
    private $elements = 0;

    /**
     * @var int
     */
    private $coveredElements = 0;

    /**
     * @var int
     */
    private $threshold;

    public function __construct(NamespacePart $namespacePart, int $threshold = 100)
    {
        $this->namespacePart = $namespacePart;
        $this->threshold = $threshold;
    }

    public function add(int $elements, int $coveredElements): void
    {
        $this->elements += $elements;
        $this->coveredElements += $coveredElements;
    }

    public function getNamespacePart(): NamespacePart
    {
        return $this->namespacePart;
    }

    public function report(): string
    {
        $status = $this->passes() ? 'OK' : 'FAILED';

        return sprintf(
            '%s %s / %s - %s',
            str_pad($status, 6),
            str_pad((string) $this->toPercentage() . '%', 4, ' ', STR_PAD_LEFT),
            str_pad((string) $this->threshold . '%', 4, ' ', STR_PAD_LEFT),
            $this->namespacePart->toString()
        );
    }

    public function passes(): bool
    {
        return $this->toPercentage() >= $this->threshold;
    }

    private function toPercentage(): int
    {
        if ($this->elements === 0) {
            return 0;
        }

        return (int) floor($this->coveredElements / $this->elements * 100);
    }
}
