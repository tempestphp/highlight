```php
{~public function parse(string $content, Highlighter $highlighter): string
{
    $pattern = '/\{\~(?<match>(.|\n)*)\~\}/';
    
    preg_match($pattern, $content, $matches);

    if ($matches === []) {
        return $content;
    }~}

    {*$content = preg_replace_callback(*}
        $pattern,
        function (array $matches) use ($highlighter) {
            $parsed = $highlighter->parse($matches['match'], $highlighter->getCurrentLanguage());
            
            return '<span class="hl-blur">' . $parsed . '</span>';
        },
        {_$content_}
    );
    
    {~return $highlighter->parse($content, $highlighter->getCurrentLanguage());
}~}
```