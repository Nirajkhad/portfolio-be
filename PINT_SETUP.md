# Pint Code Style Setup Guide

## Installation

Pint is already included in `composer.json` under `require-dev`. To ensure it's installed:

```bash
composer install
```

## Configuration

### Pint Configuration (`pint.json`)
- **Preset**: Laravel (follows Laravel framework standards)
- **PHP Version**: 8.4
- **Rules**:
  - Method chaining indentation
  - Trailing commas in multiline arrays/parameters
  - Ordered imports (class, function, const)
  - No space after not operators
  - Single line throw statements
  - Snake case for ordering

### Excluded Directories
- `bootstrap/cache`
- `storage`
- `vendor`
- `node_modules`
- `public`

## Usage

### Local Development

**Check code style (no changes):**
```bash
composer lint
# or
vendor/bin/pint --test
```

**Fix code style automatically:**
```bash
composer lint:fix
# or
vendor/bin/pint
```

**Fix specific file/directory:**
```bash
vendor/bin/pint app/Models/User.php
vendor/bin/pint app/Http/Controllers/
```

### VS Code Integration

#### Recommended Extensions

1. **PHP Intelephense** - PHP language server for better IDE features
   - ID: `bmewburn.vscode-intelephense-client`

2. **Laravel Extra Intellisense** - Laravel specific features
   - ID: `amiralizadeh9480.laravel-extra-intellisense`

3. **Blade Formatter** - Format Blade templates
   - ID: `shearer.blade-formatter`

4. **Prettier** - Format JSON/JavaScript
   - ID: `esbenp.prettier-vscode`

5. **EditorConfig** - Support .editorconfig
   - ID: `editorconfig.editorconfig`

#### Installation

```bash
code --install-extension bmewburn.vscode-intelephense-client
code --install-extension amiralizadeh9480.laravel-extra-intellisense
code --install-extension shearer.blade-formatter
code --install-extension esbenp.prettier-vscode
code --install-extension editorconfig.editorconfig
```

#### VS Code Settings

Settings are configured in `.vscode/settings.json`:

- **PHP formatting**: Format on save via Intelephense
- **Indentation**: 4 spaces (PHP), 2 spaces (YAML)
- **Rulers**: 80 and 120 character guides
- **File associations**: Blade templates, .env files
- **Auto fixes**: Trimming whitespace, final newlines

### GitHub Workflow

**File**: `.github/workflows/pint.yml`

**Triggers**:
- Push to `main` or `develop` branches
- Pull requests to `main` or `develop` branches

**What it does**:
1. Checks out code
2. Sets up PHP 8.4
3. Installs Composer dependencies
4. Runs `vendor/bin/pint --test` (non-destructive check)
5. On failure: Automatically commits fixes if running against PR

**Auto-Commit**:
- Commits use `--no-verify` to skip git hooks
- Only commits on failure (when style issues found)
- Uses GitHub Actions bot account for commits

## Best Practices

1. **Before Pushing**:
   ```bash
   composer lint:fix  # Auto-fix issues
   git add .
   git commit -m "style: apply pint fixes"
   git push
   ```

2. **Code Review**:
   - Workflow runs on all PRs
   - Check GitHub Actions tab for results
   - If failed, fixes can be auto-committed

3. **EditorConfig**:
   - Install EditorConfig VS Code extension
   - Settings automatically apply across files
   - Common override per file type in `.editorconfig`

4. **Consistency**:
   - `.editorconfig` ← Editor-level rules
   - `pint.json` ← PHP code style rules
   - `.vscode/settings.json` ← VS Code specific settings

## Troubleshooting

**Pint not found**:
```bash
composer install  # Install dev dependencies
vendor/bin/pint --version  # Verify installation
```

**Format on Save not working**:
- Ensure Intelephense is installed
- Check `.vscode/settings.json` is in workspace root
- Reload VS Code window (Cmd+Shift+P → Developer: Reload Window)

**GitHub Workflow failing**:
- Check workflow logs in GitHub Actions
- Ensure `pint.json` is in repository root
- Verify PHP version matches (8.4)

## Links

- [Laravel Pint Documentation](https://laravel.com/docs/11.x/pint)
- [EditorConfig](https://editorconfig.org/)
- [GitHub Actions Documentation](https://docs.github.com/en/actions)
