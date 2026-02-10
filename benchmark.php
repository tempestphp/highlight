<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Themes\CssTheme;

final readonly class BenchmarkResult
{
    public function __construct(
        public string $language,
        public int $codeLength,
        public float $avg,
        public float $min,
        public float $max,
        public float $p50,
        public float $p95,
    ) {}
}

final readonly class MultiLanguageResult
{
    public function __construct(
        public float $totalMs,
        public float $avgPerIteration,
    ) {}
}

final class BenchmarkRunner
{
    private Highlighter $highlighter;

    /** @var array<string, string> */
    private array $fixtures = [];

    public function __construct(
        private int $iterations = 500,
        private int $warmup = 50,
    ) {
        $this->highlighter = new Highlighter(new CssTheme());
    }

    public function addFixture(string $language, string $code): self
    {
        $this->fixtures[$language] = $code;

        return $this;
    }

    public function runSingle(string $language, string $code): BenchmarkResult
    {
        $highlighter = new Highlighter(new CssTheme());

        for ($i = 0; $i < $this->warmup; $i++) {
            $highlighter->parse($code, $language);
        }

        $times = [];

        for ($i = 0; $i < $this->iterations; $i++) {
            $start = hrtime(true);
            $highlighter->parse($code, $language);
            $end = hrtime(true);
            $times[] = ($end - $start) / 1_000_000;
        }

        sort($times);

        return new BenchmarkResult(
            language: $language,
            codeLength: strlen($code),
            avg: array_sum($times) / count($times),
            min: min($times),
            max: max($times),
            p50: $times[(int) (count($times) * 0.5)],
            p95: $times[(int) (count($times) * 0.95)],
        );
    }

    public function runMultiLanguage(): MultiLanguageResult
    {
        $highlighter = new Highlighter(new CssTheme());

        $start = hrtime(true);

        for ($i = 0; $i < $this->iterations; $i++) {
            foreach ($this->fixtures as $language => $code) {
                $highlighter->parse($code, $language);
            }
        }

        $end = hrtime(true);
        $totalMs = ($end - $start) / 1_000_000;

        return new MultiLanguageResult(
            totalMs: $totalMs,
            avgPerIteration: $totalMs / $this->iterations,
        );
    }

    /** @return array<string, BenchmarkResult> */
    public function runAll(): array
    {
        $results = [];

        foreach ($this->fixtures as $language => $code) {
            $results[$language] = $this->runSingle($language, $code);
        }

        return $results;
    }
}

final readonly class BenchmarkReport
{
    private const int SEPARATOR_WIDTH = 60;

    public function __construct(
        private int $iterations,
        private int $warmup,
    ) {}

    public function printHeader(): void
    {
        echo '=== Tempest Highlight Benchmark ===' . PHP_EOL;
        echo "Iterations: {$this->iterations} (warmup: {$this->warmup})" . PHP_EOL;
        echo 'PHP ' . PHP_VERSION . PHP_EOL;
        echo str_repeat('-', self::SEPARATOR_WIDTH) . PHP_EOL;
    }

    public function printResult(BenchmarkResult $result): void
    {
        echo sprintf(
            '%-12s | %5d chars | avg: %7.3fms | p50: %7.3fms | p95: %7.3fms | min: %7.3fms | max: %7.3fms',
            $result->language,
            $result->codeLength,
            $result->avg,
            $result->p50,
            $result->p95,
            $result->min,
            $result->max,
        ) . PHP_EOL;
    }

    public function printMultiLanguageResult(MultiLanguageResult $result): void
    {
        echo str_repeat('-', self::SEPARATOR_WIDTH) . PHP_EOL;
        echo sprintf(
            'Multi-lang   | all langs  | total: %8.1fms | avg/iter: %7.3fms',
            $result->totalMs,
            $result->avgPerIteration,
        ) . PHP_EOL;
    }

    public function printFooter(): void
    {
        echo str_repeat('-', self::SEPARATOR_WIDTH) . PHP_EOL;
        echo sprintf(
            'Peak memory: %.2f MB',
            memory_get_peak_usage(true) / 1024 / 1024,
        ) . PHP_EOL;
    }
}

final readonly class FixtureProvider
{
    /** @return array<string, string> */
    public static function all(): array
    {
        return [
            'php' => self::php(),
            'html' => self::html(),
            'javascript' => self::javascript(),
            'sql' => self::sql(),
        ];
    }

    public static function php(): string
    {
        return <<<'PHP'
        <?php

        declare(strict_types=1);

        namespace App\Services;

        use App\Models\User;
        use App\Contracts\Repository;
        use Illuminate\Support\Collection;

        #[AsService]
        final readonly class UserService implements Repository
        {
            public function __construct(
                private UserRepository $repository,
                private CacheManager $cache,
                private EventDispatcher $events,
            ) {}

            public function findById(int $id): ?User
            {
                return $this->cache->remember("user.{$id}", 3600, function () use ($id) {
                    $user = $this->repository->find($id);

                    if ($user === null) {
                        throw new UserNotFoundException("User {$id} not found");
                    }

                    $this->events->dispatch(new UserAccessed($user));

                    return $user;
                });
            }

            public function getAllActive(): Collection
            {
                return $this->repository
                    ->query()
                    ->where('status', '=', 'active')
                    ->where('deleted_at', null)
                    ->orderBy('created_at', 'desc')
                    ->get()
                    ->map(fn (User $user) => new UserDTO(
                        id: $user->id,
                        name: $user->name,
                        email: $user->email,
                        role: $user->role->getValue(),
                        isAdmin: $user->role === Role::ADMIN,
                        createdAt: $user->created_at->toISOString(),
                    ));
            }

            /**
             * @param array<string, mixed> $data
             * @return User
             * @throws ValidationException
             */
            public function create(array $data): User
            {
                $validated = $this->validate($data, [
                    'name' => 'required|string|max:255',
                    'email' => 'required|email|unique:users',
                    'password' => 'required|min:8',
                ]);

                $user = new User();
                $user->name = $validated['name'];
                $user->email = $validated['email'];
                $user->password = password_hash($validated['password'], PASSWORD_ARGON2ID);
                $user->status = 'active';
                $user->save();

                $this->events->dispatch(new UserCreated($user));
                $this->cache->forget('users.active');

                return $user;
            }

            private function validate(array $data, array $rules): array
            {
                foreach ($rules as $field => $rule) {
                    $constraints = explode('|', $rule);

                    foreach ($constraints as $constraint) {
                        match (true) {
                            $constraint === 'required' => isset($data[$field]) ?: throw new ValidationException("{$field} is required"),
                            str_starts_with($constraint, 'max:') => strlen($data[$field] ?? '') <= (int) substr($constraint, 4),
                            str_starts_with($constraint, 'min:') => strlen($data[$field] ?? '') >= (int) substr($constraint, 4),
                            $constraint === 'email' => filter_var($data[$field] ?? '', FILTER_VALIDATE_EMAIL) !== false,
                            default => true,
                        };
                    }
                }

                return $data;
            }
        }
        PHP;
    }

    public static function html(): string
    {
        return <<<'HTML'
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Dashboard</title>
            <link rel="stylesheet" href="/css/app.css">
            <script src="/js/app.js" defer></script>
        </head>
        <body class="bg-gray-100 dark:bg-gray-900">
            <nav class="bg-white shadow-lg">
                <div class="container mx-auto px-4">
                    <div class="flex justify-between items-center py-4">
                        <a href="/" class="text-2xl font-bold text-blue-600">Dashboard</a>
                        <div class="flex items-center space-x-4">
                            <span class="text-gray-700">Welcome, {{ $user->name }}</span>
                            <form method="POST" action="/logout">
                                <button type="submit" class="btn btn-danger">Logout</button>
                            </form>
                        </div>
                    </div>
                </div>
            </nav>
            <main class="container mx-auto py-8">
                <div class="grid grid-cols-3 gap-6">
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-xl font-semibold mb-4">Statistics</h2>
                        <p class="text-3xl font-bold text-blue-600">{{ $stats['total'] }}</p>
                    </div>
                </div>
            </main>
        </body>
        </html>
        HTML;
    }

    public static function javascript(): string
    {
        return <<<'JS'
        import { useState, useEffect, useCallback, useMemo } from 'react';
        import { createClient } from '@supabase/supabase-js';

        const supabase = createClient(
            process.env.NEXT_PUBLIC_SUPABASE_URL,
            process.env.NEXT_PUBLIC_SUPABASE_ANON_KEY
        );

        export function useDataFetcher(tableName, options = {}) {
            const [data, setData] = useState([]);
            const [loading, setLoading] = useState(true);
            const [error, setError] = useState(null);

            const filters = useMemo(() => ({
                limit: options.limit ?? 50,
                offset: options.offset ?? 0,
                orderBy: options.orderBy ?? 'created_at',
                ascending: options.ascending ?? false,
                ...options.filters,
            }), [options]);

            const fetchData = useCallback(async () => {
                try {
                    setLoading(true);
                    setError(null);

                    let query = supabase
                        .from(tableName)
                        .select('*')
                        .order(filters.orderBy, { ascending: filters.ascending })
                        .range(filters.offset, filters.offset + filters.limit - 1);

                    if (filters.status) {
                        query = query.eq('status', filters.status);
                    }

                    const { data: result, error: fetchError } = await query;

                    if (fetchError) throw fetchError;
                    setData(result ?? []);
                } catch (err) {
                    setError(err instanceof Error ? err.message : 'Unknown error');
                    console.error(`Failed to fetch from ${tableName}:`, err);
                } finally {
                    setLoading(false);
                }
            }, [tableName, filters]);

            useEffect(() => {
                fetchData();
                const interval = setInterval(fetchData, 30000);
                return () => clearInterval(interval);
            }, [fetchData]);

            const refetch = useCallback(() => fetchData(), [fetchData]);

            return { data, loading, error, refetch };
        }

        class DataProcessor {
            #cache = new Map();
            #maxCacheSize;

            constructor(maxCacheSize = 1000) {
                this.#maxCacheSize = maxCacheSize;
            }

            process(items) {
                return items
                    .filter(item => item !== null && item !== undefined)
                    .map(item => this.#transform(item))
                    .reduce((acc, item) => {
                        const key = item.category ?? 'uncategorized';
                        acc[key] = acc[key] ?? [];
                        acc[key].push(item);
                        return acc;
                    }, {});
            }

            #transform(item) {
                const cacheKey = JSON.stringify(item);
                if (this.#cache.has(cacheKey)) {
                    return this.#cache.get(cacheKey);
                }
                const result = {
                    ...item,
                    processedAt: new Date().toISOString(),
                    hash: this.#computeHash(item),
                };
                if (this.#cache.size >= this.#maxCacheSize) {
                    const firstKey = this.#cache.keys().next().value;
                    this.#cache.delete(firstKey);
                }
                this.#cache.set(cacheKey, result);
                return result;
            }
        }
        JS;
    }

    public static function sql(): string
    {
        return <<<'SQL'
        CREATE TABLE users (
            id BIGSERIAL PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255) UNIQUE NOT NULL,
            password_hash TEXT NOT NULL,
            role VARCHAR(50) DEFAULT 'user',
            status VARCHAR(20) DEFAULT 'active',
            created_at TIMESTAMP WITH TIME ZONE DEFAULT NOW(),
            updated_at TIMESTAMP WITH TIME ZONE DEFAULT NOW()
        );

        CREATE INDEX idx_users_email ON users(email);
        CREATE INDEX idx_users_status ON users(status) WHERE status = 'active';

        SELECT
            u.id,
            u.name,
            u.email,
            COUNT(o.id) AS order_count,
            COALESCE(SUM(o.total), 0) AS total_spent,
            MAX(o.created_at) AS last_order
        FROM users u
        LEFT JOIN orders o ON o.user_id = u.id AND o.status = 'completed'
        WHERE u.status = 'active'
            AND u.created_at >= NOW() - INTERVAL '1 year'
        GROUP BY u.id, u.name, u.email
        HAVING COUNT(o.id) > 0
        ORDER BY total_spent DESC
        LIMIT 100;
        SQL;
    }
}

$iterations = 500;
$warmup = 50;

$runner = new BenchmarkRunner($iterations, $warmup);
$report = new BenchmarkReport($iterations, $warmup);

foreach (FixtureProvider::all() as $language => $code) {
    $runner->addFixture($language, $code);
}

$report->printHeader();

foreach ($runner->runAll() as $result) {
    $report->printResult($result);
}

$report->printMultiLanguageResult($runner->runMultiLanguage());
$report->printFooter();
