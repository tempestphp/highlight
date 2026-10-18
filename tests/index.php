<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\CommonMark\Node\Block\FencedCode;
use League\CommonMark\Extension\CommonMark\Node\Inline\Code;
use League\CommonMark\MarkdownConverter;
use Tempest\Highlight\CommonMark\CodeBlockRenderer;
use Tempest\Highlight\CommonMark\InlineCodeBlockRenderer;
use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Themes\CssTheme;

$targetPaths = glob(__DIR__ . '/targets/*.md') ?: [];
sort($targetPaths);

$targets = [];

foreach ($targetPaths as $path) {
    $targets[basename($path)] = $path;
}

$defaultTarget = 'rust.md';
$targetName = (string) ($_GET['target'] ?? $defaultTarget);
$targetPath = $targets[$targetName] ?? $targets[$defaultTarget] ?? reset($targets);

if (! is_string($targetPath)) {
    http_response_code(404);
    exit('No visual test fixtures are available.');
}

$source = file_get_contents($targetPath);

if ($source === false) {
    http_response_code(500);
    exit('The selected visual test fixture could not be read.');
}

$environment = new Environment();
$highlighter = new Highlighter(new CssTheme());

$environment
    ->addExtension(new CommonMarkCoreExtension())
    ->addRenderer(FencedCode::class, new CodeBlockRenderer($highlighter))
    ->addRenderer(Code::class, new InlineCodeBlockRenderer($highlighter));

$contents = (new MarkdownConverter($environment))->convert($source)->getContent();
$themeCss = file_get_contents(__DIR__ . '/../src/Themes/Css/highlight-dark-lite.css');
$wrap = ($_GET['wrap'] ?? null) === '1';
$capture = isset($_GET['capture']);

if ($themeCss === false) {
    http_response_code(500);
    exit('The local visual test theme could not be read.');
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="color-scheme" content="dark">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Highlight visual test: <?= htmlspecialchars($targetName, ENT_QUOTES | ENT_HTML5) ?></title>
    <style>
        <?= $themeCss ?>

        :root {
            color-scheme: dark;
            background: #090c10;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-width: 1088px;
            min-height: 100vh;
            padding: 32px;
            background: #090c10;
            color: #c9d1d9;
            font: 15px/1.6 ui-sans-serif, system-ui, sans-serif;
        }

        .site-nav {
            width: 1024px;
            margin: 0 auto 20px;
        }

        .site-nav ul {
            display: flex;
            flex-wrap: wrap;
            gap: 8px 16px;
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .site-nav a {
            color: #79c0ff;
            text-decoration: none;
        }

        .site-nav a[aria-current="page"] {
            color: #f0f6fc;
            font-weight: 600;
        }

        .capture {
            width: 1024px;
            margin: 0 auto;
            overflow: hidden;
            border: 1px solid #30363d;
            border-radius: 10px;
            background: #0c0c0c;
            box-shadow: 0 16px 48px #0008;
        }

        .capture-header {
            margin: 0;
            padding: 12px 20px;
            border-bottom: 1px solid #30363d;
            background: #161b22;
            color: #8b949e;
            font: 600 13px/1.4 ui-monospace, SFMono-Regular, Consolas, monospace;
        }

        pre {
            margin: 0;
            padding: 28px 32px 32px;
            overflow-x: auto;
            border-radius: 0;
        }

        code,
        pre {
            white-space: <?= $wrap ? 'pre-wrap' : 'pre' ?>;
            tab-size: 4;
            font-family: ui-monospace, SFMono-Regular, Consolas, "Liberation Mono", monospace;
            font-size: 15px;
            line-height: 1.65;
        }

        .capture-mode .site-nav {
            display: none;
        }
    </style>
</head>
<body class="<?= $capture ? 'capture-mode' : '' ?>">
    <nav class="site-nav" aria-label="Visual test fixtures">
        <ul>
            <?php foreach ($targets as $name => $path): ?>
                <li>
                    <a href="?target=<?= urlencode($name) ?>" <?= $name === $targetName ? 'aria-current="page"' : '' ?>>
                        <?= htmlspecialchars($name, ENT_QUOTES | ENT_HTML5) ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>
    <main class="capture" data-screenshot-target="highlight-preview">
        <h1 class="capture-header"><?= htmlspecialchars($targetName, ENT_QUOTES | ENT_HTML5) ?></h1>
        <?= $contents ?>
    </main>
    <script id="visual-harness-probe">
        (() => {
            const capture = document.querySelector('[data-screenshot-target="highlight-preview"]');
            const codeSurface = capture.querySelector('pre, code');
            const captureRect = capture.getBoundingClientRect();
            const captureStyle = getComputedStyle(capture);
            const codeStyle = getComputedStyle(codeSurface);
            const resources = performance
                .getEntriesByType('resource')
                .map((entry) => new URL(entry.name, location.href).origin);

            const state = {
                target: <?= json_encode($targetName, JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_TAG) ?>,
                capture: {
                    x: captureRect.x,
                    y: captureRect.y,
                    width: captureRect.width,
                    height: captureRect.height,
                },
                styles: {
                    colorScheme: getComputedStyle(document.documentElement).colorScheme,
                    captureBackground: captureStyle.backgroundColor,
                    codeBackground: codeStyle.backgroundColor,
                },
                resourceOrigins: [...new Set(resources)],
            };

            const record = document.createElement('script');
            record.id = 'visual-harness-state';
            record.type = 'application/json';
            record.textContent = JSON.stringify(state).replaceAll('<', '\\u003c');
            document.body.append(record);
        })();
    </script>
</body>
</html>
