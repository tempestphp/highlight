```yaml
on:
  pull_request:
    types: [opened, synchronize, reopened, ready_for_review]
{+ pull_request_target: +}
{+   types: [opened, synchronize, reopened, ready_for_review] +}
```