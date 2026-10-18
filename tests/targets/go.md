```go
package main

import (
    "context"
    "fmt"
)

type Result[T any] struct {
    Value T
    Err   error
}

func collect[T comparable](ctx context.Context, input <-chan T) []Result[T] {
    results := make([]Result[T], 0, 16)

    for value := range input {
        select {
        case <-ctx.Done():
            return append(results, Result[T]{Err: ctx.Err()})
        default:
            results = append(results, Result[T]{Value: value})
        }
    }

    // Raw strings and runes use Go-specific rules.
    fmt.Printf(`collected %d values: %c\n`, len(results), '✓')
    return results
}
```
