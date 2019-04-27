<?php

declare(strict_types=1);

namespace CoverageChecker\Coverage;

use InvalidArgumentException;
use function in_array;
use function sprintf;

final class CoverageStatus
{
    private const OK = 'ok';
    private const FAILED = 'failed';
    private const IMPROVED = 'improved';

    /**
     * @var string
     */
    private $status;

    private function __construct(string $status)
    {
        if (!in_array($status, self::all(), true)) {
            throw new InvalidArgumentException(sprintf('Parameter must be one of %s.', implode(self::all())));
        }

        $this->status = $status;
    }

    public static function ok(): self
    {
        return new self(self::OK);
    }

    public static function failed(): self
    {
        return new self(self::FAILED);
    }

    public static function improved(): self
    {
        return new self(self::IMPROVED);
    }

    public static function all(): array
    {
        return [self::OK, self::FAILED, self::IMPROVED];
    }

    public function equals(self $other): bool
    {
        return $this->status === $other->status;
    }

    public function toString(): string
    {
        return $this->status;
    }
}
