```php
final readonly class BookController
{
    #[Post(uri: '/books/create')]
    public function store(BookRequest $request): Response
    {
        $book = map($request)->to(Book::class)->save();
        
        return response()
            ->redirect(uri([self::class, 'show'], id: $book->id));
    }
}
```