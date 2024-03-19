```html
<body>
    <div>
        <?php
            $sql = <<<SQL
            SELECT posts.*, authors.name  
            FROM posts
                INNER JOIN authors ON posts.author_id = authors.id
            SQL;
            
            $posts = DB::get($sql);
            
            // Don't do this IRL :)
        ?>
    </div>
</body>
```

