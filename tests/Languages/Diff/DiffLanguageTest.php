<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Diff;

use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Themes\InlineTheme;
use Tempest\Highlight\Themes\LightTerminalTheme;
use Tempest\Highlight\Themes\TerminalStyle;

class DiffLanguageTest extends TestCase
{
    public function test_highlight_unified_git_diff_in_web(): void
    {
        $content = <<<'TXT'
commit 0123456789abcdef
Merge: 1111111 2222222
Author: Tempest <hello@example.com>
diff --git a/src/Foo.php b/src/Foo.php
old mode 100644
new mode 100755
similarity index 98%
rename from src/Old.php
rename to src/Foo.php
index 1111111..2222222 100755
--- a/src/Foo.php
+++ b/src/Foo.php
@@ -1,4 +1,4 @@
 context <tag>
-old & stale
+new & fresh
\ No newline at end of file
Binary files a/logo.png and b/logo.png differ
GIT binary patch
literal 0
diff --cc src/Foo.php
index 1111111,2222222..3333333
@@@ -1,1 -1,1 +1,1 @@@
TXT;

        $highlighter = new Highlighter();

        $this->assertSame(
            <<<'HTML'
<span class="hl-comment">commit 0123456789abcdef</span>
<span class="hl-comment">Merge: 1111111 2222222</span>
<span class="hl-comment">Author: Tempest &lt;hello@example.com&gt;</span>
<span class="hl-comment">diff --git a/src/Foo.php b/src/Foo.php</span>
<span class="hl-comment">old mode 100644</span>
<span class="hl-comment">new mode 100755</span>
<span class="hl-comment">similarity index 98%</span>
<span class="hl-comment">rename from src/Old.php</span>
<span class="hl-comment">rename to src/Foo.php</span>
<span class="hl-comment">index 1111111..2222222 100755</span>
<span class="hl-type">--- a/src/Foo.php</span>
<span class="hl-type">+++ b/src/Foo.php</span>
<span class="hl-generic">@@ -1,4 +1,4 @@</span>
<span class="hl-diff-context"> context &lt;tag&gt;</span>
<span class="hl-deletion">-old &amp; stale</span>
<span class="hl-addition">+new &amp; fresh</span>
<span class="hl-comment">\ No newline at end of file</span>
<span class="hl-comment">Binary files a/logo.png and b/logo.png differ</span>
<span class="hl-comment">GIT binary patch</span>
<span class="hl-comment">literal 0</span>
<span class="hl-comment">diff --cc src/Foo.php</span>
<span class="hl-comment">index 1111111,2222222..3333333</span>
<span class="hl-generic">@@@ -1,1 -1,1 +1,1 @@@</span>
HTML,
            $highlighter->parse($content, 'diff'),
        );
    }

    public function test_highlight_unified_diff_with_inline_css(): void
    {
        $content = <<<'TXT'
diff --git a/file.txt b/file.txt
--- a/file.txt
+++ b/file.txt
@@ -1 +1 @@
 context
-removed
+added
\ No newline at end of file
TXT;

        $highlighter = new Highlighter(new InlineTheme(__DIR__ . '/../../stylesheets/diff.css'));

        $this->assertSame(
            <<<'HTML'
<span style="color: gray;">diff --git a/file.txt b/file.txt</span>
<span style="color: cyan;">--- a/file.txt</span>
<span style="color: cyan;">+++ b/file.txt</span>
<span style="color: magenta;">@@ -1 +1 @@</span>
<span class="hl-diff-context"> context</span>
<span style="color: red;">-removed</span>
<span style="color: green;">+added</span>
<span style="color: gray;">\ No newline at end of file</span>
HTML,
            $highlighter->parse($content, 'diff'),
        );
    }

    public function test_file_headers_take_precedence_over_changed_content(): void
    {
        $content = <<<'TXT'
--- old/path
+++ new/path
----removed content beginning with dashes
++++added content beginning with pluses
TXT;

        $highlighter = new Highlighter();

        $this->assertSame(
            <<<'HTML'
<span class="hl-type">--- old/path</span>
<span class="hl-type">+++ new/path</span>
<span class="hl-deletion">----removed content beginning with dashes</span>
<span class="hl-addition">++++added content beginning with pluses</span>
HTML,
            $highlighter->parse($content, 'diff'),
        );
    }

    public function test_file_header_recognition_is_hunk_state_aware(): void
    {
        $content = <<<'TXT'
--- old/path
+++ new/path
@@ -1 +1 @@
--- removed payload beginning with dashes and a space
+++ added payload beginning with pluses and a space
--- next/old/path
+++ next/new/path
TXT;

        $highlighter = new Highlighter();

        $this->assertSame(
            <<<'HTML'
<span class="hl-type">--- old/path</span>
<span class="hl-type">+++ new/path</span>
<span class="hl-generic">@@ -1 +1 @@</span>
<span class="hl-deletion">--- removed payload beginning with dashes and a space</span>
<span class="hl-addition">+++ added payload beginning with pluses and a space</span>
<span class="hl-type">--- next/old/path</span>
<span class="hl-type">+++ next/new/path</span>
HTML,
            $highlighter->parse($content, 'diff'),
        );
    }

    public function test_combined_diff_body_status_columns(): void
    {
        $content = <<<'TXT'
@@@ -1,4 -1,4 +1,5 @@@
  unchanged in both parents
- removed from the first parent
 -removed from the second parent
+ added relative to the first parent
 +added relative to the second parent
++added relative to both parents
--removed from both parents
TXT;

        $highlighter = new Highlighter();

        $this->assertSame(
            <<<'HTML'
<span class="hl-generic">@@@ -1,4 -1,4 +1,5 @@@</span>
<span class="hl-diff-context">  unchanged in both parents</span>
<span class="hl-deletion">- removed from the first parent</span>
<span class="hl-deletion"> -removed from the second parent</span>
<span class="hl-addition">+ added relative to the first parent</span>
<span class="hl-addition"> +added relative to the second parent</span>
<span class="hl-addition">++added relative to both parents</span>
<span class="hl-deletion">--removed from both parents</span>
HTML,
            $highlighter->parse($content, 'diff'),
        );
    }

    public function test_unmatched_file_header_candidates_are_parsed_in_linear_time(): void
    {
        $lineCount = 5000;
        $content = implode("\n", array_map(
            static fn (int $index): string => "--- candidate {$index}",
            range(1, $lineCount),
        ));

        $highlighter = new Highlighter();
        $startedAt = hrtime(true);
        $output = $highlighter->parse($content, 'diff');
        $elapsedSeconds = (hrtime(true) - $startedAt) / 1_000_000_000;

        $this->assertSame($lineCount, substr_count($output, '<span class="hl-deletion">'));
        $this->assertLessThan(1.0, $elapsedSeconds);
    }

    public function test_highlight_unified_git_diff_in_terminal(): void
    {
        $content = <<<'TXT'
diff --git a/file.txt b/file.txt
index 1111111..2222222 100644
--- a/file.txt
+++ b/file.txt
@@ -1 +1 @@
 context
-removed
+added
\ No newline at end of file
Binary files a/logo.png and b/logo.png differ
@@@ -1,1 -1,1 +1,1 @@@
TXT;

        $highlighter = new Highlighter(new LightTerminalTheme());
        $output = $highlighter->parse($content, 'diff');

        $this->assertSame(
            implode("\n", [
                $this->style(TerminalStyle::FG_GRAY, 'diff --git a/file.txt b/file.txt'),
                $this->style(TerminalStyle::FG_GRAY, 'index 1111111..2222222 100644'),
                $this->style(TerminalStyle::FG_DARK_CYAN, '--- a/file.txt'),
                $this->style(TerminalStyle::FG_DARK_CYAN, '+++ b/file.txt'),
                $this->style(TerminalStyle::FG_DARK_MAGENTA, '@@ -1 +1 @@'),
                ' context',
                $this->style(TerminalStyle::FG_DARK_RED, '-removed'),
                $this->style(TerminalStyle::FG_DARK_GREEN, '+added'),
                $this->style(TerminalStyle::FG_DARK_YELLOW, '\ No newline at end of file'),
                $this->style(TerminalStyle::FG_DARK_YELLOW, 'Binary files a/logo.png and b/logo.png differ'),
                $this->style(TerminalStyle::FG_DARK_MAGENTA, '@@@ -1,1 -1,1 +1,1 @@@'),
            ]),
            $output,
        );

        $this->assertSame(
            $content,
            preg_replace('/\e\[[0-9;]*m/', '', $output),
        );
    }

    private function style(TerminalStyle $style, string $content): string
    {
        return TerminalStyle::ESC->value
            . $style->value
            . $content
            . TerminalStyle::ESC->value
            . TerminalStyle::RESET->value;
    }
}
