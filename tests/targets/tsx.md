```tsx
import type { ReactNode } from 'react';

interface CollectionProps<T> {
    items: T[];
    render(item: T): ReactNode;
}

export const Collection = <T extends { id: string; active?: boolean },>(
    { items, render }: CollectionProps<T>,
): ReactNode => (
    <section aria-label="Collection">
        <UI.Toolbar count={items.length} />
        <ul {...{ role: 'list' }}>
            {items.map((item) => (
                <li key={item.id} data-active={item.active ?? false}>
                    {render(item)}
                </li>
            ))}
        </ul>
    </section>
);
```
