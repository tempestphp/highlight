```php
<?php

declare(strict_types=1);

namespace App\Test;

use Uri\Rfc3986\Uri;
use Fiber, WeakMap, Closure, Generator;

const VERSION = '1.0';
define('FLAG', true);

enum Status
{
    case Active;
    case Suspended;
}

enum Color: string
{
    case Red = 'red';
    case Blue = 'blue';
}

enum Perm: int
{
    case R = 1;
    case W = 2;
    case X = 4;
}

#[\Attribute(\Attribute::TARGET_METHOD)]
final class Route
{
    public function __construct(public readonly string $path, public readonly string $method = 'GET')
    {
    }
}

#[\NoDiscard]
function validate(mixed $v): bool
{
    return match (true) {
        is_string($v) => $v !== '',
        is_int($v) => $v >= 0,
        default => false
    };
}

interface Renderable extends \Stringable
{
    public function render(): string;
}

interface Cacheable
{
    public function cacheKey(): string;
}

trait Timestamped
{
    public \DateTimeImmutable $createdAt {
        get => $this->createdAt;
    }

    public function touch(): void
    {
        $this->createdAt = new \DateTimeImmutable();
    }
}

abstract class Entity implements Renderable, \JsonSerializable
{
    use Timestamped;

    private static int $count = 0;

    public function __construct(public readonly int $id, protected string $name)
    {
        self::$count++;
        $this->createdAt = new \DateTimeImmutable();
    }

    abstract public function toArray(): array;

    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }

    public function __toString(): string
    {
        return $this->render();
    }

    public function __debugInfo(): array
    {
        return ['id' => $this->id];
    }

    public static function total(): int
    {
        return self::$count;
    }
}

readonly class Money
{
    public function __construct(public int $amount, public string $currency = 'EUR')
    {
    }

    public function withAmount(int $a): self
    {
        return clone($this, ['amount' => $a]);
    }

    public function add(self $o): self
    {
        return clone($this, ['amount' => $this->amount + $o->amount]);
    }
}

class User extends Entity implements Cacheable
{
    public string $displayName {
        get => "{$this->name} <{$this->email}>";
        set(string $v) => $this->name = $v;
    }
    public private(set) Status $status = Status::Active;

    public function __construct(int $id, string $name, public readonly string $email, private(set) Color $color = Color::Blue)
    {
        parent::__construct($id, $name);
    }

    #[Route('/users/{id}')]
    public function render(): string
    {
        return "<user id=\"{$this->id}\">{$this->displayName}</user>";
    }

    #[\Override]
    public function toArray(): array
    {
        return ['id' => $this->id, 'name' => $this->name, 'email' => $this->email, 'status' => $this->status->name, 'color' => $this->color->value];
    }

    #[\Override]
    public function cacheKey(): string
    {
        return "u:{$this->id}";
    }

    public function suspend(): void
    {
        $this->status = Status::Suspended;
    }

    public function __serialize(): array
    {
        return $this->toArray();
    }

    public function __unserialize(array $d): void
    {
    }
}

readonly class Config
{
    public function __construct(public string $dsn, public bool $debug = false, public array $opts = [])
    {
    }

    public function withDebug(): self
    {
        return clone($this, ['debug' => true]);
    }
}

function process(Renderable&Cacheable $e): string
{
    return "{$e->cacheKey()}:{$e->render()}";
}

function fmt(string|int|float|\Stringable|null $v): string
{
    return match (true) {
        $v === null => '∅',
        is_string($v) => "\"{$v}\"",
        default => (string)$v
    };
}

function either((Renderable&Cacheable)|string $x): string
{
    return is_string($x) ? $x : process($x);
}

function fib(): Generator
{
    [$a, $b] = [0, 1];
    while (true) {
        yield $a;
        [$a, $b] = [$b, $a + $b];
    }
}

function take(Generator $g, int $n): array
{
    $r = [];
    for ($i = 0; $i < $n && $g->valid(); $i++) {
        $r[] = $g->current();
        $g->next();
    }
    return $r;
}

function slug(string $s): string
{
    return $s
            |> trim(...)
            |> mb_strtolower(...)
            |> (fn($s) => preg_replace('/\s+/', '-', $s))
            |> (fn($s) => preg_replace('/[^a-z0-9\-]/', '', $s));
}

function uri(string $u): array
{
    $p = new Uri($u);
    return ['host' => $p->getHost(), 'path' => $p->getPath()];
}

#[\Attribute(\Attribute::TARGET_METHOD)]
final class Guard
{
    public function __construct(public readonly Closure $fn)
    {
    }
}

final class Api
{
    #[Guard(static fn(object $r): bool => $r->admin ?? false)]
    public function delete(): void
    {
    }
}

function task(string $l): Fiber
{
    return new Fiber(fn(string $in) => Fiber::suspend("{$l}:{$in}"));
}

(static function (): void {
    $ext = [...['a' => 1, 'b' => 2], 'c' => 3];
    ['a' => $a] = $ext;
    $x = null;
    $v = $x?->foo ?? 'nope';
    $d = [];
    $d['k'] ??= 'def';
    $r = match ($a) {
        1 => 'one',
        default => 'other'
    };

    $mapped = array_map(strtoupper(...), ['a', 'b']);
    $sliced = array_slice(array: [5, 3, 1], offset: 0, length: 2);
    $dbl = fn(int $n): int => $n * 2;
    $add = fn(int $a) => fn(int $b): int => $a + $b;
    $fact = static function (int $n): int {
        return $n <= 1 ? 1 : $n * (Closure::getCurrent())($n - 1);
    };

    $wm = new WeakMap();
    $o = new \stdClass();
    $wm[$o] = true;
    $f = task('t');
    $f->start('in');
    $fibs = take(fib(), 8);

    $first = array_first($fibs);
    $last = array_last($fibs);
    $s = slug('  Hello World! ');
    $m = (new Money(100))->withAmount(50)->add(new Money(25));
    (void)validate('ok');
    $parts = uri('https://example.com/path?q=1');

    $u = new User(1, 'Alice', 'a@b.com', Color::Red);
    echo process($u), PHP_EOL;
    echo json_encode($u, JSON_THROW_ON_ERROR), PHP_EOL;

    $html = <<<HTML
        <h1>{$u->displayName}</h1>
    HTML;
    $raw = <<<'RAW'
        No $interpolation {$here}.
    RAW;

    try {
        throw new \RuntimeException('x');
    } catch (\RuntimeException|\LogicException $e) {
        $_ = $e->getMessage();
    } finally {
    }

    $dev = (new Config(dsn: 'sqlite::memory:', opts: ['a' => 1]))->withDebug();
    echo "slug:{$s} fibs:", implode(',', $fibs), " fact:", $fact(6), " first:{$first} last:{$last}\n";
})();
```