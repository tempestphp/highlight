```blade
<x-base title="Home">
    <x-post :foreach="$this->posts as $post">
        {{-- a comment which won't be rendered to HTML --}}
        
        {!! $post->title !!}

        <span :if="$this->showDate($post)">
            {{ $post->date }}
        </span>
        <span :else>
            -
        </span>
    </x-post>
    <div :forelse>
        <form action="…">
            <x-csrf-token />
            <math-α></math-α>
            <emotion-😍></emotion-😍>
        </form>
    </div>

    <x-footer />
</x-base>
```