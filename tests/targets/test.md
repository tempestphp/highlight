```php
function ((Foo&Bar)|null $bar) {}
function (Foo|false $bar) {}
fn((Foo&Bar)|null $post, (Foo&Bar)|null $foo) => $foo,
fn ((Foo&Bar)|null $post, (Foo&Bar)|null $foo) => $foo,
public function show(Post $post, Baz $baz): Response
public function show((Foo&Bar)|null $post, (Foo&Bar)|null $foo): Response
public function show(Foo|Bar $post, Boo $boo): Response
public function show(?Foo $post, Bar $bar): Response
public function show(Post $post, Baz $baz): Response
public function show((Foo&Bar)|null $post, (Foo&Bar)|null $foo): Response
{
public function show(Foo|Bar $post, Boo $boo): Response {
public function show(?Foo $post, Bar $bar): Response;
public function show(?Foo $post, Bar $bar);
public function show(?Foo $post, Bar $bar) {}
function(?Foo $post, Bar $bar) {}
function (?Foo $post, Bar $bar) {}

public function show(
    ?Foo $post, 
    Bar $bar
): Response;

public function show(
    ?Foo $post, 
    Bar $bar
);

public function show(
    ?Foo $post, 
    Bar $bar
) {}



fn (
    ?Foo $post, 
    Bar $bar
) => $bar,
```