<?php

declare(strict_types=1);

namespace Tests\CoverageChecker\Tests\Coverage;

use CoverageChecker\Coverage\NamespacePart;
use PHPUnit\Framework\TestCase;

final class NamespacePartTest extends TestCase
{
    /**
     * @test
     * @dataProvider provideIsPartOf
     */
    public function it_checks_if_it_is_part_of(NamespacePart $namespacePart, string $parentNamespace, bool $expected): void
    {
        self::assertSame($expected, $namespacePart->isPartOf($parentNamespace));
    }
    
    public function provideIsPartOf(): array
    {
        return [
          [new NamespacePart('App'), 'App\Foo\Bar', true],  
          [new NamespacePart('App\Foo'), 'App\Foo\Bar', true],  
          [new NamespacePart('App\Foo\Bar'), 'App\Foo\Bar', true],  
          [new NamespacePart('App\Foo'), 'App\FooBar', false],  
        ];
    }
}
