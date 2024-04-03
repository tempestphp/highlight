## 2.0.0

- `Language` interface has two new methods: `getName` and `getAliases`

```diff
interface Language
{
+    public function getName(): string;
+    public function getAliases(): array;

    …
}
```

- `BaseLanguage` is now abstract
- `Highlighter::setLanguage` is renamed to `Highlighter::addLanguage` and its signature was changed:

```diff
- public function setLanguage(string $name, Language $language): self
+ public function addLanguage(Language $language): self
```

- A new `TextLanguage`was added
- Rename `WithPre` to `WebTheme`
- `data-lang` now also works for `InlineTheme`

```diff
- interface WithPre
+ interface WebTheme extends Theme
```

- Changes to `WebTheme` method signatures:

```diff
- public function preBefore(): string;
- public function preAfter(): string;
+ public function preBefore(Highlighter $highlighter): string;
+ public function preAfter(Highlighter $highlighter): string;
```

- Moved all CSS themes from `src/Themes` to `src/Themes/Css`

## 1.3.0

- Add `data-lang` attribute to pre tags (#90)

## 1.2.1

- Fix blur bleed bug (#89)

## 1.2.0

- Added a collection of themes (#87)
- Added a new `InlineTheme`, which doesn't require loading a CSS style sheet (#88)

## 1.1.0

- Added Gutter support:

```php
$highlighter = (new \Tempest\Highlight\Highlighter())->withGutter();
```

**Note**: three new classes have been added for gutter support. If you copied over an existing theme, you'll need to add these:

```css
.hl-gutter {
    display: inline-block;
    font-size: 0.9em;
    color: #555;
    padding: 0 1ch;
}

.hl-gutter-addition {
    background-color: #34A853;
    color: #fff;
}

.hl-gutter-deletion {
    background-color: #EA4334;
    color: #fff;
}
```

**Note**: This package doesn't account for `pre` tag styling. You might need to make adjustments to how you style `pre` tags if you enable gutter support.