<?php

declare(strict_types=1);

namespace CoverageChecker\Coverage;

final class NamespacePart
{
    /**
     * @var string
     */
    private $part;

    public function __construct(string $part)
    {
        $this->part = $part;
    }

    public function isPartOf(string $namespace): bool
    {
        if ($this->part === '' || $namespace === $this->part) {
            return true;
        }
        return strpos($namespace, $this->part.'\\') === 0;
    }

    public function toString(): string
    {
        return $this->part;
    }
}
