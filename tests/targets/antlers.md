```antlers
{{# PHP Injection #}}
{{? $register = route('account.register'); ?}}
<a href="{{ $register }}">Register for a new account</a>
<a href="{{$ route('account.register') $}}">Register for a new account</a>

{{# Modifiers #}}
{{ var | modifier('hi', ['pooh', 'pea'], true, 42, $favoriteVar) }}
{{ summary | replace('worst', 'yummiest') }}
{{ summary | replace('It was', 'It was also') | replace('times', $noun) }}
{{ summary | explode(' ') | ul }}
{{ (summary | contains('best')) ?= "It was lunch, is what it was." }}

{{# Loops #}}
{{ loop from="1" to="9" }}
    {{ total += 1 }}
{{ /loop}}

{{# Sub expression #}}
{{ items = {collection:products sort="rating:desc" limit="5"} }}

{{# Antlers collections #}}
{{ collection:blog }}
    {{ once }}
        {{ push:scripts }}
            <script src="//unpkg.com/alpinejs" defer></script>
        {{ /push:scripts }}
    {{ /once }}
    {{ partial:blog/card }}
{{ /collection:blog }}

{{# Antlers variables #}}
{{ perfectenschlag }} 

{{ skaters:0:name }}
{{ skaters.1.name }}
{{ skaters[2]['name'] }}

{{
  testimonials
  limit="5"
  order="username"
}}

I live in {{ mailing_address:city }}. It's in {{ mailing_address:province }}.

{{# Switch #}}
{{ switch(
        (size == 'sm') => '(min-width: 768px) 35vw, 90vw',
        (size == 'md') => '(min-width: 768px) 55vw, 90vw',
        (size == 'lg') => '(min-width: 768px) 75vw, 90vw',
        (size == 'xl') => '90vw',
        () => '100vw'
    )
}}

{{# Antlers Comparaison #}}
{{ if songs === 1 }}
    <p>This is a song!</p>
{{ elseif songs > 100 }}
    <p>This is noisy!</p>
{{ elseif songs }}
    <p>There are some songs here.</p>
{{ else }}
    <p>It is quiet.</p>
{{ /if }}

{{# Here's a more complicated condition involving the output from a Tag. #}}
{{ if {collection:count from="episodes"} >= 100 }}
    This show is ready to be syndicated!
{{ /if }}

{{ 404 }}

{{#
  Multiline comment
  <h1>{{ title }}</h1>
  <div>{{ date }}</div>
  <div class="markdown">{{ content }}</div>
#}}
```