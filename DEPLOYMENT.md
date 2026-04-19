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
3. Nixpacks installs PHP 8.4 + dependencies
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
# Application (IMPORTANT: Set these correctly for Filament to work!)
APP_NAME="Portfolio API"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-app.up.railway.app
ASSET_URL=https://your-app.up.railway.app

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

## 🔄 Automatic Deployments via Railway

Railway automatically deploys your application when you push to the `main` branch through its **GitHub Integration**. No GitHub Actions or manual deployment needed!

### How It Works

1. **Push to GitHub:**
   ```bash
   git add .
   git commit -m "Update application"
   git push origin main
   ```

2. **Railway Detects Changes:**
   - Railway monitors your repository
   - Automatically triggers deployment on push to main
   - No manual intervention required

3. **Deployment Process:**
   - Nixpacks builds your application (PHP 8.4 + dependencies)
   - Runs `start.sh` startup script
   - Executes migrations
   - Optimizes for production
   - Health check at `/up` endpoint
   - App goes live automatically

### Monitor Deployments

**Railway Dashboard:**
- Go to https://railway.app/dashboard
- Click on your project
- View **"Deployments"** tab for real-time logs
- Check build progress, startup logs, and errors

**What to Look For:**
```
✅ Build successful
✅ Starting deployment...
✅ Running migrations...
✅ Health check passed
✅ Deployment live
```

### Deployment Logs Location

In Railway dashboard:
1. Click your Laravel service
2. Go to **"Deployments"** tab
3. Click on latest deployment
4. View build logs and startup logs

---

## 🔐 Security Best Practices

### Environment Variables in Railway

All sensitive configuration is managed securely in Railway's dashboard:

**✅ Benefits:**

1. **Encrypted Storage**
   - Railway encrypts all environment variables at rest
   - Not visible in repository or Git history
   - Secure transmission to application

2. **Easy Management**
   - Update variables without code changes
   - Instant propagation to application (after redeploy)
   - No commits needed for configuration changes

3. **Environment Isolation**
   - Separate production and staging environments
   - Different credentials per environment
   - Zero chance of credential leaks

4. **Reference Other Services**
   - Use `${{Postgres.PGHOST}}` syntax
   - Automatically injects database credentials
   - Services auto-discover each other

### Secret Management Tips

1. **Use Strong Keys**
   ```bash
   # Good: Generated by Laravel
   php artisan key:generate --show

   # Bad: Manual or weak keys
   # APP_KEY=mykey123  ❌
   ```

2. **Rotate Regularly**
   - Regenerate `APP_KEY` when team members leave
   - Update database passwords periodically
   - Rotate credentials every 90 days

3. **Principle of Least Privilege**
   - Only configure variables that are needed
   - Use read-only database users where possible
   - Limit service access

4. **Never Commit Secrets**
   ```bash
   # Bad - secrets in repository
   .env file committed  ❌

   # Good - secrets in Railway dashboard
   All secrets in Railway Variables  ✅
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
- PHP version - Railway uses PHP 8.4 by default (configured in nixpacks.toml)

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

### Filament Admin Panel - No CSS/Styling

If Filament admin panel loads but has no styling:

**1. Check APP_ENV and APP_URL:**
```env
APP_ENV=production  # Must be "production" not "local"
APP_URL=https://your-actual-railway-domain.up.railway.app  # Exact domain
ASSET_URL=https://your-actual-railway-domain.up.railway.app  # Same as APP_URL
```

**2. Get your Railway domain:**
- Railway → Service → Settings → Networking → Copy the domain
- Update `APP_URL` with the exact domain (no trailing slash)
- Redeploy after changing

**3. Clear caches manually (if needed):**
```bash
# In Railway Terminal
php artisan optimize:clear
php artisan filament:optimize
```

**4. Check deployment logs:**
Look for: `🎨 Optimizing Filament assets...` and `✅ Production optimization complete`

**Common causes:**
- ❌ `APP_ENV=local` instead of `production`
- ❌ Wrong `APP_URL` (doesn't match Railway domain)
- ❌ Missing `ASSET_URL`
- ❌ View cache cleared after optimization

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


## �📖 Additional Resources

- [Railway Documentation](https://docs.railway.app/)
- [Railway GitHub Integration](https://docs.railway.app/deploy/integrations)
- [Laravel Deployment Best Practices](https://laravel.com/docs/deployment)
- [Security Documentation](./SECURITY.md)

---

**Need Help?** Check Railway's [Discord community](https://discord.gg/railway) or [GitHub Discussions](https://github.com/railwayapp/railway/discussions)
