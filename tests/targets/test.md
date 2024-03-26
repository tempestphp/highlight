```twig
{% from 'forms.html' import input as input_field, textarea %}

<p>{{ input_field('password', '', 'password') }}</p>
<p>{{ textarea('comment') }}</p>
```