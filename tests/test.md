```php
$class = new readonly class {
    public function __construct(
        public string $foo = 'bar',
    ) {}
};
```