```c
#include <stddef.h>
#include <stdio.h>

typedef struct Result {
    const char *label;
    unsigned long value;
} Result;

static Result make_result(const char *label, unsigned long value)
{
    return (Result) {
        .label = label,
        .value = value,
    };
}

int main(void)
{
    const Result result = make_result("answer", 42ULL);

    // C strings, types, declarations, and member access.
    printf("%s: %lu\n", result.label, result.value);

    return result.value == 42ULL ? 0 : 1;
}
```
