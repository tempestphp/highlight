```php
#[ConsoleCommand]
public function info(
    #[ConsoleArgument(
        description: 'The name of the package',
        help: 'Extended help text for this argument',
        aliases: ['n'],
    )]
    string $name
): void {}
```