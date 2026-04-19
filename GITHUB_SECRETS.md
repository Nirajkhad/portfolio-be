# GitHub Secrets Configuration Guide

Complete reference for configuring GitHub Secrets for CI/CD deployment.

## 🔐 Senior-Level Security Approach

**Zero Hardcoded Values** → **100% GitHub Secrets** → **Maximum Security**

The workflow builds `.env` entirely from GitHub Secrets. No credentials ever touch your repository.

---

## ⚡ Quick Setup (Minimum Required)

Add this secret to deploy:

```bash
# Get Railway Token
# Visit: https://railway.app/account/tokens
# Copy the token (starts with: railway_...)
# Add as: RAILWAY_TOKEN
```

**That's it!** Railway manages all application environment variables (APP_KEY, database credentials, etc.) directly in their platform.

> **Note:** The workflow only needs `RAILWAY_TOKEN` for deployment. Configure your application settings (APP_KEY, CORS, database, etc.) in Railway's dashboard, not in GitHub Secrets.

---

## 📋 Complete Secrets Reference

### How to Add Secrets

1. Go to your GitHub repository
2. Click: **Settings** → **Secrets and variables** → **Actions**
3. Click: **"New repository secret"**
4. Enter name and value
5. Click: **"Add secret"**

---

## 🔑 Required Secret

| Secret Name | How to Get | Priority |
|------------|-----------|----------|
| `RAILWAY_TOKEN` | https://railway.app/account/tokens | ⚠️ Required |

> **All other configuration** (APP_KEY, database, CORS, etc.) is managed in Railway's dashboard, not in GitHub Secrets.

---

## 📝 Why Only RAILWAY_TOKEN?

The GitHub Actions workflow is streamlined for deployment only:

1. **Push to `main` branch**
2. **GitHub Actions triggers**
3. **Railway CLI deploys using RAILWAY_TOKEN**
4. **Railway uses its own environment variables**

**Benefits:**
- ✅ Simpler workflow (no test secrets needed)
- ✅ Faster deployments
- ✅ Fewer secrets to manage
- ✅ Railway dashboard is single source of truth
- ✅ Environment variables managed where they're used

---

## 🗄️ Application Configuration (Managed in Railway)

These are configured in **Railway Dashboard**, not GitHub Secrets:

### Required in Railway:
- `APP_KEY` - Generate with: `php artisan key:generate --show`
- `APP_ENV` - Set to: `production`
- `APP_DEBUG` - Set to: `false`
- `APP_URL` - Your Railway app URL

### Database (Auto-configured by Railway):
- `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`
- Railway automatically injects these when you add PostgreSQL

### Security Settings (Configure in Railway):
- `CORS_ALLOWED_ORIGINS` - Your frontend URL
- `API_RATE_LIMIT` - e.g., `100`
- `SECURITY_HSTS_ENABLED` - `true` for production
- `TRUST_PROXIES` - `true`

See [DEPLOYMENT.md](./DEPLOYMENT.md) for complete Railway configuration guide.

---

## ~~📱 Application Secrets (Optional - Use Defaults)~~

**DEPRECATED:** These are no longer needed in GitHub Secrets.
Configure in Railway dashboard instead.

## 🎯 Setup Summary

### What You Need:
1. **GitHub Secret:** `RAILWAY_TOKEN` only
2. **Railway Dashboard:** All app configuration (APP_KEY, CORS, DB, etc.)

### Deployment Flow:
```
Push to main → GitHub Actions → Railway CLI → Deploy!
                    ↓
              Uses RAILWAY_TOKEN
                    ↓
          Railway uses its own env vars
```

### Configuration Checklist:

**In GitHub (1 secret):**
- [ ] `RAILWAY_TOKEN` - Railway deployment token

**In Railway Dashboard:**
- [ ] `APP_KEY` - Laravel application key
- [ ] `APP_ENV=production`
- [ ] `APP_DEBUG=false`
- [ ] `APP_URL` - Your Railway URL
- [ ] `CORS_ALLOWED_ORIGINS` - Your frontend URL
- [ ] Database connection (auto-configured when you add PostgreSQL)
- [ ] Security headers enabled
- [ ] Rate limiting configured

---

## ~~🌐 CORS Secrets~~
## ~~🛡️ Security Headers Secrets~~
## ~~🚦 Rate Limiting Secrets~~
## ~~🔒 Input Sanitization Secrets~~
## ~~🌍 Proxy & Host Trust Secrets~~
## ~~💾 Session & Cache Secrets~~
## ~~📝 Logging Secrets~~

**DEPRECATED:** All application configuration is now managed in Railway dashboard, not GitHub Secrets.

The GitHub Actions workflow only needs `RAILWAY_TOKEN` for deployment.

---

## 🎯 Recommended Setup

### Minimal Setup (Deploy Only)
```
GitHub Secrets:
  RAILWAY_TOKEN ← Only this!

Railway Dashboard:
  APP_KEY
  APP_ENV=production
  APP_DEBUG=false
  APP_URL=https://your-app.up.railway.app
  CORS_ALLOWED_ORIGINS=https://yourfrontend.com
```

This is all you need for a production deployment!

## 🔍 Verifying Your Setup

**Check GitHub Secret:**

1. Go to: **Settings** → **Secrets and variables** → **Actions**
2. You should see: `RAILWAY_TOKEN` (value is hidden for security)

**Check Railway Configuration:**

1. Go to Railway dashboard → Your project → Service
2. Click **"Variables"** tab
3. Verify you have:
   - `APP_KEY`
   - `APP_ENV=production`
   - `APP_DEBUG=false`
   - `CORS_ALLOWED_ORIGINS`
   - Database variables (auto-injected by Railway)

**Test Deployment:**

```bash
git add .
git commit -m "Test deployment"
git push origin main
```

Watch the **Actions** tab on GitHub for the deployment workflow.

---

## 🚨 Security Best Practices

### ✅ DO:
- Store `RAILWAY_TOKEN` in GitHub Secrets
- Configure app settings in Railway dashboard
- Use strong, randomly generated `APP_KEY`
- Rotate `RAILWAY_TOKEN` regularly (every 90 days)
- Enable 2FA on your GitHub account
- Set `APP_DEBUG=false` in production
- Use specific CORS origins (no `*`)

### ❌ DON'T:
- Commit `.env` files to repository
- Hardcode credentials anywhere
- Share `RAILWAY_TOKEN` via Slack/email
- Use the same tokens across projects
- Set `APP_DEBUG=true` in production
- Allow `CORS_ALLOWED_ORIGINS=*` in production

---

## 📖 References

- [GitHub Encrypted Secrets](https://docs.github.com/en/actions/security-guides/encrypted-secrets)
- [Laravel Security Best Practices](https://laravel.com/docs/security)
- [OWASP Secrets Management](https://cheatsheetseries.owasp.org/cheatsheets/Secrets_Management_Cheat_Sheet.html)

---

## 🆘 Troubleshooting

**Workflow fails with "RAILWAY_TOKEN not found":**
→ Add `RAILWAY_TOKEN` secret in GitHub repo settings

**Deployment succeeds but app doesn't work:**
→ Check Railway dashboard for `APP_KEY` and other required environment variables

**App shows "Application key not set" error:**
→ Generate APP_KEY in Railway: `php artisan key:generate --show`
→ Add it to Railway variables, not GitHub Secrets

**Database connection errors:**
→ Verify PostgreSQL service is added in Railway
→ Check database credentials in Railway variables tab

**CORS errors from frontend:**
→ Update `CORS_ALLOWED_ORIGINS` in Railway with your frontend domain

**Changes to environment variables not taking effect:**
→ Redeploy from Railway dashboard or push a new commit

---

**Remember: Only `RAILWAY_TOKEN` goes in GitHub Secrets. Everything else goes in Railway! **🔒
