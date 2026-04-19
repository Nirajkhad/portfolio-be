# Railway Deployment Guide

Deploy your Laravel Portfolio API to **Railway** for FREE (no credit card required) with automated GitHub Actions deployments.

## 🚀 Why Railway?

- ✅ **$5 free credit/month** (no credit card needed)
- ✅ **PostgreSQL database included**
- ✅ **No sleep/cold starts**
- ✅ **Custom domains supported**
- ✅ **Simple configuration**
- ✅ **Automatic deployments from GitHub**
- ✅ **No Docker required** - Uses Nixpacks for automatic builds

---

## 📦 Deployment Method: Nixpacks (Zero Docker Config)

Your app deploys using **Nixpacks**, not Docker:

**What is Nixpacks?**
- Railway's smart build system
- Automatically detects PHP/Laravel
- No Dockerfile needed
- Faster than Docker builds
- Zero configuration required

**How it works:**
1. Push code to GitHub
2. Railway detects Laravel automatically
3. Nixpacks installs PHP 8.3 + dependencies
4. Your app is live!

**Configuration files:**
- `railway.toml` - Railway deployment settings
- `nixpacks.toml` - Build configuration (optional customization)

> **Note:** The `.docker/` folder is only for local development. Railway deployment doesn't use Docker at all!

---

## 📋 Prerequisites

- GitHub account
- Railway account ([sign up at railway.app](https://railway.app))
- Your code pushed to GitHub repository

---

## 🔧 Step-by-Step Deployment

### Step 1: Create Railway Account

1. Go to **[Railway.app](https://railway.app/)**
2. Click **"Login"** → **"Login with GitHub"**
3. Authorize Railway to access your GitHub
4. No credit card required! You get $5/month free credit

### Step 2: Create New Project

1. From Railway dashboard, click **"New Project"**
2. Select **"Deploy from GitHub repo"**
3. Choose your `portfolio-be` repository
4. Railway will detect it's a Laravel/PHP project

### Step 3: Add PostgreSQL Database

1. In your Railway project, click **"+ New"**
2. Select **"Database"** → **"Add PostgreSQL"**
3. Database will be created and auto-linked to your app
4. Railway automatically injects database credentials

### Step 4: Configure Environment Variables

1. Click on your Laravel service (not the database)
2. Go to **"Variables"** tab
3. Add these environment variables:

```env
# Application
APP_NAME="Portfolio API"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-app.up.railway.app

# Database (use Railway's references)
DB_CONNECTION=pgsql
DB_HOST=${{Postgres.PGHOST}}
DB_PORT=${{Postgres.PGPORT}}
DB_DATABASE=${{Postgres.PGDATABASE}}
DB_USERNAME=${{Postgres.PGUSER}}
DB_PASSWORD=${{Postgres.PGPASSWORD}}

# Security - CORS (update with your frontend URL)
CORS_ALLOWED_ORIGINS=https://yourfrontend.com
CORS_ALLOWED_METHODS=GET,POST,PUT,PATCH,DELETE,OPTIONS
CORS_ALLOWED_HEADERS=Content-Type,Authorization,X-Requested-With,Accept,Origin
CORS_MAX_AGE=86400
CORS_SUPPORTS_CREDENTIALS=false

# Security - Rate Limiting
API_RATE_LIMIT=100
API_RATE_LIMIT_DECAY=1

# Security - Headers
SECURITY_REFERRER_POLICY=strict-origin-when-cross-origin
SECURITY_PERMISSIONS_POLICY="geolocation=(), microphone=(), camera=()"
SECURITY_CSP_ENABLED=true
SECURITY_CSP="default-src 'self'; script-src 'self'; style-src 'self'"
SECURITY_HSTS_ENABLED=true
SECURITY_HSTS_MAX_AGE=31536000
SECURITY_HSTS_SUBDOMAINS=true

# Security - Proxy Trust
TRUST_PROXIES=true
TRUSTED_PROXIES=*

# Session & Cache
SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database

# Logging
LOG_CHANNEL=stack
LOG_LEVEL=error
```

### Step 5: Generate APP_KEY

**Option A - Generate Locally:**
```bash
php artisan key:generate --show
```
Copy the output and add it to Railway variables as `APP_KEY`

**Option B - Generate in Railway:**
1. Wait for first deployment
2. Go to your service → Click **"..."** menu → **"Terminal"**
3. Run: `php artisan key:generate --show`
4. Copy the key
5. Add it to Variables as `APP_KEY`
6. Redeploy

### Step 6: Get Your Public URL

1. In Railway, click on your Laravel service
2. Go to **"Settings"** → **"Networking"**
3. Click **"Generate Domain"**
4. You'll get a URL like: `https://portfolio-api.up.railway.app`
5. Update `APP_URL` in your environment variables with this URL

### Step 7: First Deployment

Railway automatically deploys when you push to GitHub. Your app is now live!

Check deployment logs in Railway dashboard to ensure everything worked.

---

## 🔄 GitHub Actions - Automated Deployments

Automatically deploy when you push to `main` branch.

### Step 1: Get Railway Token

1. Go to **[Railway Account Settings](https://railway.app/account/tokens)**
2. Click **"Create Token"**
3. Give it a name (e.g., "GitHub Actions")
4. Copy the token (starts with `railway_...`)

### Step 2: Generate Application Key

Generate a secure application key locally:

```bash
php artisan key:generate --show
```

Copy the output (e.g., `base64:abcd1234...`). You'll need this for GitHub secrets.

### Step 3: Add GitHub Secrets (Senior-Level Security)

1. Go to your GitHub repository
2. Click **"Settings"** → **Secrets and variables** → **"Actions"**
3. Click **"New repository secret"**

> **🔒 Security Best Practice:** The workflow uses GitHub Secrets for deployment credentials. Zero hardcoded values = zero security risks.

#### Required Secret (Deployment)

| Secret Name | Description | How to Get |
|------------|-------------|------------|
| `RAILWAY_TOKEN` | Railway deployment token | Get from: https://railway.app/account/tokens |

> **Note:** Only `RAILWAY_TOKEN` is required for deployment. Railway manages all application environment variables directly in their platform.

#### Optional: Application Configuration (For CI/CD Testing)

If you plan to add testing back to the workflow later, you can configure these secrets:

| Secret Name | Default | Description |
|------------|---------|-------------|
| `APP_NAME` | `Portfolio API` | Application name |
| `APP_ENV` | `testing` | Environment (testing for CI) |
| `APP_DEBUG` | `true` | Debug mode for tests |
| `APP_URL` | `http://localhost` | Application URL for tests |
| `APP_LOCALE` | `en` | Default locale |
| `APP_FALLBACK_LOCALE` | `en` | Fallback locale |

#### Test Database Configuration

| Secret Name | Default | Description |
|------------|---------|-------------|
| `TEST_DB_NAME` | `testing` | Test database name |
| `TEST_DB_USER` | `test_user` | Test database username |
| `TEST_DB_PASSWORD` | `test_password_secure_123` | Test database password |
| `DB_CONNECTION` | `pgsql` | Database driver |
| `DB_HOST` | `localhost` | Database host |
| `DB_PORT` | `5432` | Database port |

#### Security - CORS Configuration

| Secret Name | Default | Description |
|------------|---------|-------------|
| `CORS_ALLOWED_ORIGINS` | `http://localhost:3000` | Comma-separated allowed origins |
| `CORS_ALLOWED_METHODS` | `GET,POST,PUT,PATCH,DELETE,OPTIONS` | Allowed HTTP methods |
| `CORS_ALLOWED_HEADERS` | `Content-Type,Authorization,X-Requested-With,Accept,Origin` | Allowed headers |
| `CORS_EXPOSED_HEADERS` | `` | Headers to expose |
| `CORS_MAX_AGE` | `3600` | Preflight cache duration |
| `CORS_SUPPORTS_CREDENTIALS` | `false` | Allow credentials |

#### Security - Rate Limiting

| Secret Name | Default | Description |
|------------|---------|-------------|
| `API_RATE_LIMIT` | `60` | Requests per decay period |
| `API_RATE_LIMIT_DECAY` | `1` | Decay period (minutes) |

#### Security - Headers & Policies

| Secret Name | Default | Description |
|------------|---------|-------------|
| `SECURITY_REFERRER_POLICY` | `strict-origin-when-cross-origin` | Referrer policy |
| `SECURITY_PERMISSIONS_POLICY` | `geolocation=(), microphone=(), camera=()` | Permissions policy |
| `SECURITY_CSP_ENABLED` | `false` | Enable Content Security Policy |
| `SECURITY_CSP` | `default-src self` | CSP directives |
| `SECURITY_HSTS_ENABLED` | `false` | Enable HSTS (HTTPS only) |
| `SECURITY_HSTS_MAX_AGE` | `31536000` | HSTS max age |
| `SANITIZE_INPUT` | `true` | Enable input sanitization |
| `STRIP_HTML_TAGS` | `false` | Strip HTML from input |

#### Security - Proxy & Host Trust

| Secret Name | Default | Description |
|------------|---------|-------------|
| `TRUST_PROXIES` | `false` | Trust proxy headers |
| `TRUSTED_PROXIES` | `*` | Trusted proxy IPs |
| `TRUST_HOSTS` | `false` | Trust host headers |
| `TRUSTED_HOSTS_LIST` | `localhost` | Trusted hosts |

#### Session & Cache

| Secret Name | Default | Description |
|------------|---------|-------------|
| `SESSION_DRIVER` | `array` | Session driver for tests |
| `SESSION_LIFETIME` | `120` | Session lifetime (minutes) |
| `CACHE_STORE` | `array` | Cache store for tests |
| `QUEUE_CONNECTION` | `sync` | Queue connection for tests |

#### Logging

| Secret Name | Default | Description |
|------------|---------|-------------|
| `LOG_CHANNEL` | `stack` | Log channel |
| `LOG_LEVEL` | `debug` | Log level |

---

**How to Add Secrets:**

```bash
# Get Railway Token
# Visit: https://railway.app/account/tokens
# Copy: railway_abc123...

# Add to GitHub
# Repo → Settings → Secrets and variables → Actions → New repository secret
```

**Steps:**
1. Click **"New repository secret"**
2. Name: `RAILWAY_TOKEN`
3. Value: Your Railway token (from above)
4. Click **"Add secret"**
5. Done! You're ready to deploy

**Minimum Required Setup:**
- Just add `RAILWAY_TOKEN` (Railway deployment token)
- That's it! No other secrets needed for basic deployment
- Customize only what you need for your specific use case

**Production Setup:**
- Add all CORS secrets with your frontend URLs
- Enable security headers (`SECURITY_HSTS_ENABLED=true`)
- Set appropriate rate limits
- Configure CSP if needed

### Step 4: Workflow is Ready!

Your repository already has `.github/workflows/deploy-railway.yml` configured!

**What the workflow does:**
- ✅ Automatically deploys to Railway on every push to `main` branch
- ✅ Uses Railway CLI for deployment
- ✅ Zero credentials in repository or logs
- ✅ Simple and fast deployment process

Push to `main` to trigger deployment:

```bash
git add .
git commit -m "Deploy to Railway"
git push origin main
```

Watch the deployment in **Actions** tab on GitHub!

> **Note:** The workflow only deploys. Run tests locally before pushing: `php artisan test`

---

## 🔐 Security Best Practices

### Why Build .env from Secrets?

Our GitHub Actions workflow builds the `.env` file from GitHub secrets instead of copying `.env.example`. Here's why this matters:

**✅ Benefits:**

1. **No Credentials in Repository**
   - `.env` never stored in Git history
   - Safe even in public repositories
   - No accidental credential commits

2. **Encrypted Storage**
   - GitHub encrypts all secrets at rest
   - Only accessible during workflow runs
   - Not visible in logs or pull requests

3. **Easy Rotation**
   - Update secrets without changing code
   - Revoke and regenerate tokens instantly
   - No need to commit changes to rotate credentials

4. **Environment Isolation**
   - Different secrets for different branches
   - Production vs staging vs testing separation
   - Per-environment configuration

5. **Audit Trail**
   - GitHub logs when secrets are accessed
   - Track who added/modified secrets
   - Security compliance ready

**❌ Why NOT to Copy .env.example:**

```bash
# DON'T DO THIS (insecure)
- name: Setup env
  run: |
    cp .env.example .env
    echo "DB_PASSWORD=hardcoded123" >> .env  # ❌ Visible in logs!
```

**✅ Instead Do This (secure):**

```bash
# DO THIS (secure)
- name: Create .env from secrets
  env:
    DB_PASS: ${{ secrets.DB_PASSWORD }}  # ✅ Encrypted, not in logs
  run: |
    echo "DB_PASSWORD=${DB_PASS}" > .env
```

### Secret Management Tips

1. **Use Strong Keys**
   ```bash
   # Good: Generated by Laravel
   php artisan key:generate --show

   # Bad: Manual or weak keys
   # APP_KEY=mykey123  ❌
   ```

2. **Rotate Regularly**
   - Rotate `RAILWAY_TOKEN` every 90 days
   - Regenerate `APP_KEY` when team members leave
   - Update database passwords periodically

3. **Principle of Least Privilege**
   - Only add secrets that are needed
   - Use read-only database users where possible
   - Limit token scopes and permissions

4. **Never Log Secrets**
   ```bash
   # Bad - secrets visible in logs
   echo "Password is: ${{ secrets.DB_PASSWORD }}"  ❌

   # Good - use secrets without logging
   DB_PASSWORD=${{ secrets.DB_PASSWORD }}  ✅
   ```

---

## 🎯 Post-Deployment Tasks

### 1. Run Database Seeders (Optional)

If you have seeders:

1. Go to Railway → Your service → **"Terminal"**
2. Run: `php artisan db:seed --force`

### 2. Update Frontend CORS

Update your `.env` or Railway variables with your actual frontend URL:

```env
CORS_ALLOWED_ORIGINS=https://yourfrontend.vercel.app,https://yourfrontend.com
```

### 3. Test Your API

```bash
# Health check
curl https://your-app.up.railway.app/up

# Test API endpoint
curl https://your-app.up.railway.app/api/v1/posts
```

### 4. Monitor Usage

Railway gives you $5/month free credit. Monitor usage:
1. Go to Railway dashboard
2. Click on your project
3. Check **"Usage"** tab
4. Average small Laravel API uses $2-3/month

### 5. Set Up Custom Domain (Optional)

1. In Railway → Service → **"Settings"** → **"Networking"**
2. Click **"Custom Domain"**
3. Enter your domain: `api.yourdomain.com`
4. Add the CNAME record to your DNS provider:
   - Type: `CNAME`
   - Name: `api`
   - Value: `your-app.up.railway.app`
5. Wait for DNS propagation (can take up to 48 hours)

---

## 🐛 Troubleshooting

### App Won't Start

**Check Logs:**
1. Railway → Your service → **"Deployments"**
2. Click latest deployment → View logs

**Common Issues:**
- Missing `APP_KEY` - Generate and add to variables
- Database connection error - Check database variables (`${{Postgres.PGHOST}}` etc.)
- PHP version - Railway uses PHP 8.3 by default

### 500 Internal Server Error

1. Enable debug mode temporarily:
   ```env
   APP_DEBUG=true
   LOG_LEVEL=debug
   ```
2. Check logs in Railway
3. Fix the issue
4. **Set `APP_DEBUG=false` again!**

### Migration Failures

Run migrations manually:
1. Railway → Service → **"Terminal"**
2. Run: `php artisan migrate:fresh --force`

### CORS Errors

1. Check `CORS_ALLOWED_ORIGINS` includes your frontend URL
2. No trailing slashes in URLs
3. Redeploy after changing CORS settings

### Out of Credit

Railway's free $5/month usually lasts the whole month for small apps.

If you run out:
- Check what's using resources (logs, database size)
- Optimize database queries
- Consider upgrading (still cheap, ~$5/month)

---

## 📚 Useful Commands

```bash
# View logs
railway logs

# SSH into container
railway shell

# Run artisan commands
railway run php artisan migrate

# Link local project to Railway
railway link

# Deploy from local
railway up
```

---

## ✅ Deployment Checklist

Before going to production:

- [ ] `APP_DEBUG=false` in Railway variables
- [ ] `APP_ENV=production` set
- [ ] Strong `APP_KEY` generated
- [ ] Database connected and migrations run
- [ ] CORS origins set to actual frontend URL (no `*`)
- [ ] Security headers enabled (`SECURITY_HSTS_ENABLED=true`)
- [ ] Rate limiting configured appropriately
- [ ] Custom domain configured (optional)
- [ ] GitHub Actions working
- [ ] API endpoints tested and working
- [ ] Logs monitored for errors

---

## 🎉 You're Done!

Your Laravel API is now deployed to Railway with:

- ✅ Automatic deployments from GitHub
- ✅ PostgreSQL database
- ✅ SSL/HTTPS enabled
- ✅ Security headers configured
- ✅ CORS protection
- ✅ Rate limiting
- ✅ Professional monitoring

**Your API URL:** `https://your-app.up.railway.app/api/v1/`

---

## � Quick Reference - GitHub Secrets

Copy this checklist when setting up GitHub secrets:

### Required Secrets (Must Add)

```bash
# 1. RAILWAY_TOKEN
# Get from: https://railway.app/account/tokens
# Example value: railway_aBcD1234EfGh5678IjKl9012MnOp3456

# 2. APP_KEY
# Generate with: php artisan key:generate --show
# Example value: base64:abcd1234efgh5678ijkl9012mnop3456qrst7890uvwx1234yz56
```

### Optional Secrets (Use Defaults if Not Set)

```bash
# Test Database Name (default: testing)
TEST_DB_NAME=testing

# Test Database User (default: test_user)
TEST_DB_USER=test_user

# Test Database Password (default: test_password_secure_123)
TEST_DB_PASSWORD=your_secure_password_here
```

### How to Add Secrets - Step by Step

1. Go to your GitHub repository
2. Click: **Settings** → **Secrets and variables** → **Actions**
3. Click: **New repository secret**
4. Add each secret:
   - Name: `RAILWAY_TOKEN` → Value: (your Railway token) → **Add secret**
   - Name: `APP_KEY` → Value: (your Laravel key) → **Add secret**
5. Done! Your workflow will use these secrets automatically

### Verify Secrets Are Set

In your repository:
- Go to **Settings** → **Secrets and variables** → **Actions**
- You should see: `RAILWAY_TOKEN`, `APP_KEY`
- Optionally: `TEST_DB_NAME`, `TEST_DB_USER`, `TEST_DB_PASSWORD`

---

## �📖 Additional Resources

- [Railway Documentation](https://docs.railway.app/)
- [Railway CLI](https://docs.railway.app/develop/cli)
- [Laravel Deployment Best Practices](https://laravel.com/docs/deployment)
- [Security Documentation](./SECURITY.md)

---

**Need Help?** Check Railway's [Discord community](https://discord.gg/railway) or [GitHub Discussions](https://github.com/railwayapp/railway/discussions)
