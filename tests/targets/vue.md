```vue
<!-- A Vue 3 SFC counter-and-list component -->
<script setup lang="ts">
import { ref, computed, watch } from 'vue'

type Todo = { id: number; text: string; done: boolean }

const props = defineProps<{
	title: string
	initial?: Todo[]
}>()

const emit = defineEmits<{
	update: [todos: Todo[]]
}>()

const draft = ref('')
const todos = ref<Todo[]>(props.initial ?? [])
const filter = ref<'all' | 'active' | 'done'>('all')

const visible = computed(() => {
	switch (filter.value) {
		case 'active': return todos.value.filter((t) => !t.done)
		case 'done':   return todos.value.filter((t) => t.done)
		default:       return todos.value
	}
})

const remaining = computed(() => todos.value.filter((t) => !t.done).length)

watch(todos, (next) => {
	emit('update', next)
}, { deep: true })

function add() {
	if (!draft.value.trim()) return
	todos.value.push({ id: Date.now(), text: draft.value, done: false })
	draft.value = ''
}
</script>

<template>
	<h1>{{ title }}</h1>

	<form @submit.prevent="add">
		<input v-model="draft" placeholder="What needs doing?" />
		<button type="submit">Add</button>
	</form>

	<select v-model="filter">
		<option value="all">All</option>
		<option value="active">Active</option>
		<option value="done">Done</option>
	</select>

	<ul>
		<li v-for="todo in visible" :key="todo.id" :class="{ done: todo.done }">
			<input type="checkbox" v-model="todo.done" />
			{{ todo.text }}
		</li>
	</ul>

	<p v-if="filter === 'all'">Showing everything.</p>
	<p v-else-if="filter === 'active'">Showing active todos.</p>
	<p v-else>Showing {{ remaining }} remaining.</p>
</template>

<style scoped lang="scss">
h1 {
	color: red;

	&:hover {
		color: blue;
	}
}

.done {
	text-decoration: line-through;
}
</style>
```
