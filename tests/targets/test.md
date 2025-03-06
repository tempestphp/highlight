```blade
{{-- The post's title --}}

@if($post->title)
    <h1>{{ $post->title }}</h1>  
    <p>{!! $post->body !!}</p>  
@else
    <span>-</span>
@endif
```