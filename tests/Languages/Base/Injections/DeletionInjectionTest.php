<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Base\Injections;

use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Languages\Base\Injections\DeletionInjection;
use Tempest\Highlight\Languages\Blade\BladeLanguage;
use Tempest\Highlight\Languages\Php\PhpLanguage;

class DeletionInjectionTest extends TestCase
{
    public function test_deletion_injection()
    {
        $content = <<<TXT
{- class Foo -}
{{-- class Foo --}}
TXT;

        $highlighter = new Highlighter();
        $highlighter->setCurrentLanguage(new BladeLanguage());

        $injection = new DeletionInjection();

        $output = $injection->parse($content, $highlighter);

        $this->assertSame(
            trim(<<<TXT
<span class="hl-deletion"> class Foo </span>
<span class="hl-comment">{{-- <span class="hl-keyword">class</span> <span class="hl-type">Foo</span> --}}</span>
TXT),
            trim($output),
        );
    }
}
