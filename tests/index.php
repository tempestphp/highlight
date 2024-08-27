<?php

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

$environment = new Environment();

$highlighter = (new Highlighter(new CssTheme()));

$environment
    ->addExtension(new CommonMarkCoreExtension())
    ->addRenderer(FencedCode::class, new CodeBlockRenderer($highlighter))
    ->addRenderer(Code::class, new InlineCodeBlockRenderer($highlighter))
;

$markdown = new MarkdownConverter($environment);

$target = 'targets' . DIRECTORY_SEPARATOR . 'test.md';

if (isset($_GET['target'])) {
    $target = $_GET['target'];
}

$contents = $markdown->convert(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . $target))->getContent();

$wrap = false;

if (isset($_GET['wrap'])) {
    $wrap = (bool) $_GET['wrap'];
}

$stylesheet = null;

if (isset($_GET['stylesheet'])) {
    $stylesheet = $_GET['stylesheet'];
}

?>

<html>
<head>
    <title>Test</title>
    <style>
        <?= file_get_contents(__DIR__ . '/../src/Themes/Css/highlight-light-lite.css') ?>

        body {
            font-size: 15px;
            background-color: #232323;
        }

        code,
        pre {
            overflow-x: <?php echo $wrap ? 'auto' : 'scroll' ?>;
            white-space: <?php echo $wrap ? 'normal' : 'pre' ?>;
            line-height: 1.8em;
            font-family: "JetBrains Mono", monospace;
            padding: .1em;
        }

        pre {
            margin: 3em auto;
            box-shadow: 0 0 10px 0 #00000044;
            /*padding: 2em 2em 2em 1ch;*/
            padding: 2em;
            /*background-color: #fafafa;*/
            border-radius: 3px;
            color: #000;
            background-color: #f3f3f3;
        }

        .container {
            display: flex;
            align-items: center;
            /*height: 100vh;*/
        }

        .hl-injection {
            /*background-color: #f0000044;*/
        }
    </style>
    <?php if ($stylesheet): ?>
        <link rel="stylesheet" href="<?php echo $stylesheet; ?>">
    <?php endif; ?>
</head>
<body>
<div class="container">
    <?= $contents ?>
</div>
</body>
</html>
