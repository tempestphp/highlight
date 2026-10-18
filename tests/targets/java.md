```java
package demo.highlight;

import java.time.Instant;
import java.util.List;

@Deprecated(forRemoval = false)
public record Event<T>(String name, T payload, Instant createdAt) {
    public Event {
        if (name.isBlank()) {
            throw new IllegalArgumentException("name must not be blank");
        }
    }
}

sealed interface Outcome permits Success, Failure {}

record Success(String message) implements Outcome {}

record Failure(Throwable cause) implements Outcome {}

public final class EventFormatter<T> {
    private static final long MAX_EVENTS = 0xCAFE_F00DL;

    public List<String> format(List<Event<T>> events) {
        return events.stream()
            .map(event -> """
                %s: %s
                """.formatted(event.name(), event.payload()))
            .toList();
    }
}
```
