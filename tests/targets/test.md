```php{1}
$environment = new Environment();

$theme = new InlineTheme(__DIR__ . {+'/../src/Themes/solarized-dark.css'+}));

$highlighter = (new Highlighter($theme))->withGutter();

$environment
    ->addExtension(new CommonMarkCoreExtension())
    ->addRenderer(FencedCode::class, new CodeBlockRenderer($highlighter))
    ->addRenderer(Code::class, new InlineCodeBlockRenderer($highlighter));
```