```csharp
#nullable enable

using System.Collections.Generic;
using System.Linq;

namespace Demo.Highlight;

/// <summary>Formats immutable events for the audit stream.</summary>
[AttributeUsage(AttributeTargets.Class)]
public sealed class AuditedAttribute : Attribute {}

public readonly record struct Event<T>(Guid Id, string Name, T Payload);

public interface IRepository<T> where T : notnull
{
    IAsyncEnumerable<T> StreamAsync(CancellationToken cancellationToken = default);
}

[Audited]
public sealed class EventFormatter
{
    private const decimal Rate = 12.5m;
    private const string Root = @"C:\logs";

    public required string Prefix { get; init; }

    public async Task<string> FormatAsync<T>(Event<T>? item) where T : notnull
    {
        ArgumentNullException.ThrowIfNull(item);

        var names = from value in new[] { item.Name }
                    where !string.IsNullOrWhiteSpace(value)
                    select value.Trim();

        await Task.Yield();

        return $"""{Prefix}: {string.Join(", ", names)} ({item.Payload})""";
    }
}
```
