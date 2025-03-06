```blade
{{-- The post's title --}}

@if($post->title)
    <h1>{{ $post->title }}</h1>  
@else
    <span>-</span>
@endif
```