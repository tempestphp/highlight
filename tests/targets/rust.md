```rust
#![allow(dead_code)]

use std::fmt::Display;

#[derive(Debug)]
struct Point<'a, T> {
    label: &'a str,
    value: T,
}

impl<'a, T: Display> Point<'a, T> {
    fn render(&self) -> String {
        format!(r#"{}: {}"#, self.label, self.value)
    }
}

fn main() {
    // Raw strings and typed numbers use Rust-specific rules.
    let point = Point { label: "answer", value: 42_u8 };
    println!("{}", point.render());
}
```
