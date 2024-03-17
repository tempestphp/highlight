# Fast, extensible, server-side code highlighting

- [Quickstart](#quickstart)
- [Themes](#themes)
  - [For the web](#for-the-web)
  - [For the terminal](#for-the-terminal)
- [Special highlighting tags](#special-highlighting-tags)
  - [Emphasize strong and blur](#emphasize-strong-and-blur)
  - [Additions and deletions](#additions-and-deletions)
  - [Custom classes](#custom-classes)
  - [Inline languages](#inline-languages)
- [Commonmark integration](#commonmark-integration)
- [Adding or extending languages](#adding-or-extending-languages)

TODO:

- [ ] Add JS support
- [ ] Add SQL support
- [ ] Add Twig support
- [ ] Add YAML support
- [ ] Add JSON support

## Quickstart

```php
composer require tempest/highlight:dev-main
```

Highlight code like this:

```php
$highlighter = new \Tempest\Highlight\Highlighter();

$code = $highlighter->parse($escapedCode, 'php');
```

**Note: you should always pass the _escaped_ version of your code**:

```php
$code = $highlighter->parse(htmlentities($raw), 'php');
```

## Themes

### For the web

For HTML rendering, you can use one of the provided themes that comes with this package:

```css
@import "../vendor/tempest/highlight/src/Themes/highlight-light-lite.css";
```

You can build your own CSS theme with just a couple of classes:

```css
.hl-keyword {
    color: #4F95D1;
}

.hl-property {
    color: #46b98d;
}

.hl-attribute {
    font-style: italic;
}

.hl-type {
    color: #D14F57;
}

.hl-generic {
    color: #9D3AF6;
}

.hl-comment {
    color: #888888;
}

.hl-blur {
    filter: blur(2px);
}

.hl-strong {
    font-weight: bold;
}

.hl-em {
    font-style: italic;
}

.hl-addition {
    display: inline-block;
    min-width: 100%;
    background-color: #00FF0033;
}

.hl-deletion {
    display: inline-block;
    min-width: 100%;
    background-color: #FF000022;
}
```

Note that `pre` tag styling isn't included in this package.

### For the terminal

```php
use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Themes\TerminalTheme;

$highlighter = new Highlighter(new TerminalTheme());

echo html_entity_decode($highlighter->parse(htmlentities($code), 'php'));
```

![](./.github/terminal.png)

## Special highlighting tags

This package offers a collection of special tags that you can use within your code snippets. These tags won't be shown in the final output, but rather adjust the highlighter's default styling. All these tags work multi-line, and will still properly render its wrapped content.

### Emphasize, strong, and blur

You can add these tags within your code to emphasize or blur parts:

- `{_ content _}` adds the `.hl-em` class
- `{* content *}` adds the `.hl-strong` class
- `{~ content ~}` adds the `.hl-blur` class

Here's an example:

```php
{~public function parse(string $content, Highlighter $highlighter): string
{
    $pattern = '/\{\~(?<match>(.|\n)*)\~\}/';
    
    preg_match($pattern, $content, $matches);

    if ($matches === []) {
        return $content;
    }~} // This part is blurred

    {*$content = preg_replace_callback(*} // This line is bold
        $pattern,
        function (array $matches) use ($highlighter) {
            $parsed = $highlighter->parse($matches['match'], $highlighter->getCurrentLanguage());
            
            return '<span class="hl-blur">' . $parsed . '</span>';
        },
        {_$content_} // This line is cursive
    );
    
    {~return $highlighter->parse($content, $highlighter->getCurrentLanguage());
}~}
```

This is the end result:

![](./.github/highlight.png)

### Additions and deletions

You can use these two tags to mark lines as additions and deletions:

- `{+ content +}` adds the `.hl-addition` class
- `{- content -}` adds the `.hl-deletion` class

```php
{-public class Foo {}-}
{+public class Bar {}+}
```

![](./.github/highlight-2.png)

As a reminder: all these tags work multi-line as well:


```php
  public function before(TokenType $tokenType): string
  {
      $style = match ($tokenType) {
          {-TokenType::KEYWORD => TerminalStyle::FG_DARK_BLUE,
          TokenType::PROPERTY => TerminalStyle::FG_DARK_GREEN,
          TokenType::TYPE => TerminalStyle::FG_DARK_RED,
          TokenType::GENERIC => TerminalStyle::FG_DARK_CYAN,
          TokenType::VALUE => TerminalStyle::FG_BLACK,
          TokenType::COMMENT => TerminalStyle::FG_GRAY,
          TokenType::ATTRIBUTE => TerminalStyle::RESET,-}
      };
  
      return TerminalStyle::ESC->value . $style->value;
  }
```

### Custom classes

You can add any class you'd like by using the <code>{&#96;classname&#96; content &#96;}</code> tag:

<pre>
&lt;style&gt;
.hl-a {
    background-color: #FFFF0077;
}

.hl-b {
    background-color: #FF00FF33;
}
&lt;/style&gt;

&#96;&#96;&#96;php
{&#96;hl-a&#96;public class Foo {}&#96;}
{&#96;hl-b&#96;public class Bar {}&#96;}
&#96;&#96;&#96;
</pre>

![](./.github/highlight-3.png)

### Inline languages

Within inline Markdown code tags, you can specify the language by prepending it between curly brackets: 

<pre>
&#96;{php}public function before(TokenType $tokenType): string&#96;
</pre>

You'll need to set up [commonmark](#commonmark-integration) properly to get this to work.

## CommonMark integration

If you're using `league/commonmark`, you can highlight codeblocks and inline code like so:

```php
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\CommonMark\Node\Block\FencedCode;
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
```

Keep in mind that you need to manually install `league/commonmark`:

```php
composer require league/commonmark;
```

## Adding or extending languages

This package makes it easy for developers to add new languages or extend existing languages. Right now, these languages are supported: `php`, `html`, `css`, and `blade`. More will be added.

In order to build your own highlighter functionality, you need to understand _three_ concepts of how code is highlighted: _patterns_, _injections_, and _languages_.

### 1. Patterns

A _pattern_ represents part of your code that should be highlighted. A _pattern_ can target a single keyword like `return` or `class`, or it could be any part of your code, like for example a comment: `/* this is a comment */` or an attribute: `#[Get(uri: '/')]`.

Each _pattern_ is represented by a simple class that provides a regex pattern, and a `TokenType`. The regex pattern is used to match relevant content to this specific _pattern_, while the `TokenType` is an enum value that will determine how that specific _pattern_ is colored.

Here's an example of a simple _pattern_ to match the namespace of a PHP file:

```php
use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\Tokens\TokenType;

final readonly class NamespacePattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return 'namespace (?<match>[\w\\\\]+)';
    }

    public function getTokenType(): TokenType
    {
        return TokenType::TYPE;
    }
}
```

Note that each pattern must include a regex capture group that's named `match`. The content that matched within this group will be highlighted.

For example, this regex `namespace (?<match>[\w\\\\]+)` says that every line starting with `namespace` should be taken into account, but only the part within the named group `(?<match>…)` will actually be colored. In practice that means that the namespace name matching `[\w\\\\]+`, will be colored.

Yes, you'll need some basic knowledge of regex. Head over to [https://regexr.com/](https://regexr.com/) if you need help, or take a look at the existing patterns in this repository.

**In summary:**

- Patterns provide a regex that matches parts of your code
- Those regexes should contain a group named `match`, which is written like so `(?<match>…)`
- Finally, a pattern provides a `TokenType`, which is used to determine the highlight style for the specific match

### 2. Injections

Once you've understood patterns, the next step is to understand _injections_. _Injections_ are used to highlight different languages within one code block. For example: HTML could contain CSS, which should be styled properly as well.

An _injection_ class will tell the highlighter that it should treat a block of code as a different language. For example:

```html
<div>
    <x-slot name="styles">
        <style>
            body {
                background-color: red;
            }
        </style>
    </x-slot>
</div>
```

Everything within these `<style></style>` tags should be treated as CSS. That's done by this class:

```php
use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Injection;
use Tempest\Highlight\IsInjection;

final readonly class CssInjection implements Injection
{
    use IsInjection;

    public function getPattern(): string
    {
        return '&lt;style&gt;(?<match>(.|\n)*)&lt;\/style&gt;';
    }

    public function parseContent(string $content, Highlighter $highlighter): string
    {
        return $highlighter->parse($content, 'css');
    }
}
```

Just like patterns, an _injection_ must provide a pattern. This pattern, for example, will match anything between style tags: `&lt;style&gt;(?<match>(.|\n)*)&lt;\/style&gt;`.

**Keep in mind that we're always dealing with escaped code!**

The second step in providing an _injection_ is to parse the matched content into another language. That's what the `parseContent` method is for. In this case, we'll get all the code between the style tags that was matched with the named `(?<match>…)` group, and parse that content as CSS instead of whatever language we're currently dealing with.

**In summary:**

- Injections provide a regex that matches a blob of code of language A, while in language B
- Just like patterns, injection regexes should contain a group named `match`, which is written like so `(?<match>…)`
- Finally, an injection will use the highlighter to parse its matched content into another language

### 3. Languages

The last concept to understand, although it doesn't mean much. _Languages_ are classes that bring these two concepts together. They are nothing more than a collection of patterns and injections. Take a look at the `HtmlLanguage`, for example:

```php
class HtmlLanguage implements Language
{
    public function getInjections(): array
    {
        return [
            new PhpInjection(),
            new PhpShortEchoInjection(),
            new CssInjection(),
        ];
    }

    public function getPatterns(): array
    {
        return [
            new OpenTagPattern(),
            new CloseTagPattern(),
            new TagAttributePattern(),
            new HtmlCommentPattern(),
        ];
    }
}
```

This `HtmlLanguage` class specifies the following things:

- PHP can be injected within HTML, both with the short echo tag `<?=` and longer `<?php` tags
- CSS can be injected as well, JavaScript support is still work in progress
- There are a bunch of patterns to highlight HTML tags properly

So, let's bring everything together to explain how you can add your own languages.

### Adding custom languages

Let's say you're adding [Blade](https://laravel.com/docs/11.x/blade) support. You could create a plain language file and start from there, but it'd probably be easier to extend an existing language, `HtmlLanguage` is probably the best. Let create a new `BladeLanguage` class that extends from `HtmlLanguage`:

```php
class BladeLanguage extends HtmlLanguage
{
    public function getInjections(): array
    {
        return [
            ...parent::getInjections(),
        ];
    }

    public function getPatterns(): array
    {
        return [
            ...parent::getPatterns(),
        ];
    }
}
```

With this class in place, we can start adding our own patterns and injections. Let's start with adding a pattern that matches all Blade keywords, which are always prepended with the `@` sign. Let's add it:

```php
final readonly class BladeKeywordPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?<match>\@[\w]+)\b';
    }

    public function getTokenType(): TokenType
    {
        return TokenType::KEYWORD;
    }
}
```

And register it in our `BladeLanguage` class:

```php
    public function getPatterns(): array
    {
        return [
            ...parent::getPatterns(),
            new BladeKeywordPattern(),
        ];
    }
```

Next, there are a couple of places within Blade where you can write PHP code: within the `@php` keyword, as well as within keyword brackets: `@if (count(…))`. Let's write two injections for that:

```php
final readonly class BladeKeywordInjection implements Injection
{
    use IsInjection;

    public function getPattern(): string
    {
        return '(\@[\w]+)\s?\((?<match>.*)\)';
    }

    public function parseContent(string $content, Highlighter $highlighter): string
    {
        return $highlighter->parse($content, 'php');
    }
}
```

```php
final readonly class BladePhpInjection implements Injection
{
    use IsInjection;

    public function getPattern(): string
    {
        return '\@php(?<match>(.|\n)*?)\@endphp';
    }

    public function parseContent(string $content, Highlighter $highlighter): string
    {
        return $highlighter->parse($content, 'php');
    }
}
```

Let's add these to our `BladeLanguage` class as well:

```php
    public function getInjections(): array
    {
        return [
            ...parent::getInjections(),
            new BladePhpInjection(),
            new BladeKeywordInjection(),
        ];
    }
```

And, finally, you can write `{{ … }}` and `{!! … !!}` to echo output. Whatever is between these brackets is also considered PHP, so, one more injection:

```php
final readonly class BladeEchoInjection implements Injection
{
    use IsInjection;

    public function getPattern(): string
    {
        return '({{|{!!)(?<match>.*)(}}|!!})';
    }

    public function parseContent(string $content, Highlighter $highlighter): string
    {
        return $highlighter->parse($content, 'php');
    }
}
```

With all of that in place, the only thing left to do is to add our language to the highlighter:

```php
$highlighter->addLanguage('blade', new BladeLanguage());
```

And you're done! Blade support with just a handful of patterns and injections. 

**You're free to send pull requests with additional language support! Take a look at the [tests](./tests/Languages) to learn how to write tests for patterns and injections.**