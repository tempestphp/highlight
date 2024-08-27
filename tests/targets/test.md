```php
    public function __construct(
        // Allow a union on a special "missing relation" type:
        public Relation|Author $author,

        // Making the relation nullable would be an option as well:
        /** @var Chapter[] $chapters */
        /**
         * hello */
        public ?array $chapters,
    ) {}
``` 