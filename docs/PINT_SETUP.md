# Pint Code Style

Laravel Pint is included as a dev dependency for automatic PHP code style fixing.

## Configuration

**File:** `pint.json`

- **Preset:** Laravel
- **PHP Version:** 8.4
- Excludes: `bootstrap/cache/`, `storage/`, `vendor/`, `node_modules/`, `public/`

## Usage

```bash
composer lint       # check style (no changes)
composer lint:fix   # auto-fix style violations

# Or directly:
vendor/bin/pint --test   # check
vendor/bin/pint          # fix
vendor/bin/pint app/Models/User.php  # single file
```

## CI

A GitHub Actions workflow (`.github/workflows/pint.yml`) runs on push/PR to `main`/`develop`. If style violations are found, fixes are auto-committed.
