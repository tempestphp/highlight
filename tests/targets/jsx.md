```jsx
import { useMemo } from 'react';

export function Dashboard({ user, items, ...cardProps }) {
    const total = useMemo(() => items.length, [items]);

    return (
        <>
            <header data-theme="midnight">
                <UI.Icon name="activity" aria-hidden />
                <h1>Hello&nbsp;{user.name}</h1>
            </header>

            <Card {...cardProps} title="Recent activity" compact>
                {/* JSX expressions retain JavaScript highlighting. */}
                {items.map((item) => (
                    <Card.Row key={item.id} selected={item.active}>
                        <strong>{item.label}</strong>
                    </Card.Row>
                ))}
                <footer>{total} items</footer>
            </Card>

            <svg:path d="M0 0h12v12z" />
        </>
    );
}
```
