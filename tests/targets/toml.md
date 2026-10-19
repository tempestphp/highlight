```toml
# Application settings
title = "Nightly Service"
"site owner" = 'Operations'
enabled = true
ports = [8000, 8001, 8002]
ratio = 6.626e-34
mask = 0xFF_EC_DE_5E
released = 2026-10-19T03:45:00Z
alarm = 07:30:00
description = """A multiline
service description."""

[database.primary]
host = "db.internal"
credentials = { user = "service", retries = 3 }

[[servers]]
name = "api-01"
roles = ["web", "worker"]

[[servers]]
name = "api-02"
roles = ["web"]
```
