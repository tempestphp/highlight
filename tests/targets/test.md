```php
foreach ($lines as $i => $line) {
    {~$gutterNumber = $gutterNumbers[$i];~}

{+    $gutterClass = 'hl-gutter ' . ($this->classes[$i + 1] ?? '');+}
{++}
{+    $lines[$i] = sprintf(+}
{+        Escape::tokens('<span class="%s">%s</span>%s'),+}
{-        $gutterClass,-}
{+        str_pad(+}
{+            string: $gutterNumber,+}
{+            length: $gutterWidth,+}
{+            pad_type: STR_PAD_LEFT,+}
{+        ),+}
{+        $line,+}
{+    );+}
}
```