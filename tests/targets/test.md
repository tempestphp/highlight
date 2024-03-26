```twig
{% extends "admin/empty_base.html.twig" %}

{% block javascripts %}
    {{ parent() }}
	
    <script>
        const mainSearchUrl = "";
        const customerUrl = "";
    </script>
{% endblock %}
```