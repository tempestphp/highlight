<?php

require_once __DIR__ . '/../vendor/autoload.php';

use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\CommonMark\Node\Block\FencedCode;
use League\CommonMark\Extension\CommonMark\Node\Inline\Code;
use League\CommonMark\MarkdownConverter;
use Tempest\Highlight\CommonMark\CodeBlockRenderer;
use Tempest\Highlight\CommonMark\InlineCodeBlockRenderer;

$environment = new Environment();

$environment
    ->addExtension(new CommonMarkCoreExtension())
    ->addRenderer(FencedCode::class, new CodeBlockRenderer())
    ->addRenderer(Code::class, new InlineCodeBlockRenderer())
;

$markdown = new MarkdownConverter($environment);

$contents = $markdown->convert(file_get_contents(__DIR__ . '/test-big.md'))->getContent();

?>

<html>
<head>
    <title>Test</title>
    <style>
        <?= file_get_contents(__DIR__ . '/../src/Themes/highlight-light-lite.css') ?>

        body {
            font-size: 15px;
        }

        code,
        pre {
            overflow-x: scroll;
            line-height: 1.8em;
            font-family: "JetBrains Mono", monospace;
        }

        code {

        }

        .hl {
            width: 800px;
            margin: 3em auto;
            box-shadow: 0 0 10px 0 #00000044;
            padding: 1em 2em;
            background-color: #fafafa;
            border-radius: 3px;
        }
    </style>
</head>
<body>
<div class="hl">
    <?= $contents ?>
</div>
</body>
</html>
