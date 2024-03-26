```twig
{% with %}
    {% set foo = 42 %}
    {{ foo }} {# foo is 42 here #}
{% endwith %}
```