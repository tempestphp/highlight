```kotlin
package demo.highlight

import java.time.Instant

@JvmInline
value class EventId(val value: String)

data class Event<T>(
    val id: EventId,
    val name: String,
    val payload: T,
    val createdAt: Instant,
)

sealed interface Outcome

data class Success(val message: String) : Outcome

data class Failure(val cause: Throwable) : Outcome

typealias Handler<T> = (Event<T>) -> Outcome

object EventFormatter {
    fun <T> format(events: List<Event<T>>): List<String> =
        events.map { event ->
            """
            ${event.name}: ${event.payload}
            """.trimIndent()
        }

    fun <T> validate(event: Event<T>?): Outcome =
        event?.let { Success("valid") }
            ?: Failure(IllegalArgumentException("event"))
}
```
