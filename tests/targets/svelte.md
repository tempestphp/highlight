```svelte
<script lang="ts">
	type Todo = { id: number; text: string; done: boolean };

	let { initial = [], onchange }: { initial?: Todo[]; onchange?: (t: Todo[]) => void } = $props();

	let draft = $state('');
	let todos = $state<Todo[]>(initial);
	let filter = $state<'all' | 'active' | 'done'>('all');
	
	let count = $state(0);
	let doubled = $derived(count * 2);

	let visible = $derived.by(() => {
		switch (filter) {
			case 'active': return todos.filter((t) => !t.done);
			case 'done':   return todos.filter((t) => t.done);
			default:       return todos;
		}
	});
	
	let remaining = $derived(todos.filter((t) => !t.done).length);

	$effect(() => {
		onchange?.(todos);
	});

	$inspect(remaining).with((type, value) => {
		console.log(type, value);
	});

	function add() {
		if (!draft.trim()) return;
		todos.push({ id: Date.now(), text: draft, done: false });
		draft = '';
	}
</script>

<button onclick={() => count++}>
	{doubled}
</button>

<form onsubmit={(e) => { e.preventDefault(); add(); }}>
	<input bind:value={draft} placeholder="What needs doing?" />
	<button type="submit">Add</button>
</form>

<select bind:value={filter}>
	<option value="all">All</option>
	<option value="active">Active</option>
	<option value="done">Done</option>
</select>

<ul>
	{#each visible as todo (todo.id)}
		<li class:done={todo.done}>
			<input type="checkbox" bind:checked={todo.done} />
			{todo.text}
		</li>
	{:else}
		<li>Nothing here.</li>
	{/each}
</ul>

{#if filter === 'all'}
	<p>Showing everything.</p>
{:else if filter === 'active'}
	<p>Showing active todos.</p>
{:else if filter === 'done'}
	<p>Showing completed todos.</p>
{:else}
	<p>Unknown filter.</p>
{/if}

<!-- nested-brace expressions inside block tags -->

{#each entries as { key, value }}
	<dt>{key}</dt>
	<dd>{value}</dd>
{/each}

{#each todos.filter((t) => ({ ...t, label: t.text.trim() })) as todo (todo.id)}
	<li>{todo.label}</li>
{/each}

{#each Object.entries({ a: 1, b: 2, c: 3 }) as [key, value]}
	<p>{key} = {value}</p>
{/each}

{#if items.some((x) => x.meta?.tags?.includes('urgent'))}
	{@const summary = { count: items.length, urgent: true }}
	<p>{summary.count} urgent items</p>
{/if}
```
