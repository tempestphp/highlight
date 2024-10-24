```php
// controller for home
final readonly class HomeController
{
    #[Get(uri: '/home')]
    public function __invoke(): View
    {
        return view('Views/home.view.php')
            ->data(
                name: 'Brent',
                date: new DateTime(),
            );
    }

    #[Post(uri: '/home')]
    public function __invoke(): View
    {
    }
}
```