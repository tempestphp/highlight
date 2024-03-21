```php
$foo = null;
$foo = true;
$foo = false;
while(true) {}

function (Foo|null $bar);
function (Foo|true $bar);
function (Foo|false $bar);
function ((Foo&Bar)|null $bar);
```