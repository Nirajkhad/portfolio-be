# Portfolio API

A secure, production-ready Laravel API for managing portfolio content including projects, experiences, skills, and blog posts.

## 🚀 Features

- ✅ **RESTful API** - Clean API endpoints for portfolio management
- ✅ **PostgreSQL Database** - Reliable data storage
- ✅ **Filament Admin Panel** - Easy content management
- ✅ **Comprehensive Security** - CORS, rate limiting, security headers
- ✅ **Railway Deployment** - Free hosting with automatic deployments
- ✅ **No Docker Required** - Nixpacks for simple deployments

## 📋 API Endpoints

### General Information
- `GET /api/v1/portfolio` - Get portfolio owner information
- `GET /api/v1/general-infos` - Get all general information

### Experiences
- `GET /api/v1/experiences` - List all work experiences
- `GET /api/v1/experiences/{id}` - Get specific experience

### Projects
- `GET /api/v1/projects` - List all projects
- `GET /api/v1/projects/featured` - Get featured projects

### Skills
- `GET /api/v1/skills` - List all skills
- `GET /api/v1/skills/grouped` - Get skills grouped by category

### Posts
- `GET /api/v1/posts` - List all posts
- `GET /api/v1/posts/published` - List published posts only
- `GET /api/v1/posts/{slug}` - Get specific post by slug

## 🔒 Security Features

- **CORS Protection** - Configurable allowed origins
- **Rate Limiting** - Prevent API abuse (100 requests/minute default)
- **Security Headers** - HSTS, CSP, X-Frame-Options, etc.
- **Input Sanitization** - Automatic input cleaning
- **Proxy Trust** - Support for load balancers
- **Environment Secrets** - GitHub Secrets integration

See [SECURITY.md](SECURITY.md) for detailed security documentation.

## 🛠️ Local Development

### Prerequisites
- PHP 8.4+
- PostgreSQL 15+
- Composer
- Node.js 20+

### Setup

```bash
# Clone the repository
git clone <your-repo-url>
cd portfolio-be

# Install dependencies
composer install
npm install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Configure your database in .env
# DB_CONNECTION=pgsql
# DB_HOST=localhost
# DB_PORT=5432
# DB_DATABASE=portfolio
# DB_USERNAME=your_username
# DB_PASSWORD=your_password

# Run migrations
php artisan migrate

# (Optional) Seed database
php artisan db:seed

# Start development server
php artisan serve
```

Your API will be available at `http://localhost:8000`

### Running Tests

```bash
php artisan test
```

### Code Style

This project uses Laravel Pint for code formatting:

```bash
./vendor/bin/pint
```

## 🚢 Deployment

### Railway (Recommended - FREE)

Deploy to Railway with automatic GitHub integration:

1. **Sign up at [Railway.app](https://railway.app)** (no credit card required)
2. **Connect your GitHub repository** to Railway
3. **Add PostgreSQL database** to your project
4. **Configure environment variables** in Railway dashboard
5. **Push to `main` branch** - automatic deployment!

📚 **Full deployment guide:** [DEPLOYMENT.md](DEPLOYMENT.md)

### Quick Deploy

```bash
# Simply push to main branch:
git push origin main
# Railway automatically detects and deploys!
```

## 📖 Documentation

- **[DEPLOYMENT.md](DEPLOYMENT.md)** - Complete Railway deployment guide
- **[SECURITY.md](SECURITY.md)** - Security features and best practices
- **[SECURITY_SETUP.md](SECURITY_SETUP.md)** - Quick security configuration
- **[GITHUB_SECRETS.md](GITHUB_SECRETS.md)** - GitHub Secrets reference

## 🔧 Configuration

### Environment Variables

Key configuration in `.env`:

```env
# Application
APP_NAME="Portfolio API"
APP_ENV=production
APP_KEY=base64:your-key-here
APP_DEBUG=false
APP_URL=https://your-app.up.railway.app

# Database (Auto-configured by Railway)
DB_CONNECTION=pgsql
DB_HOST=${{Postgres.PGHOST}}
DB_PORT=${{Postgres.PGPORT}}
DB_DATABASE=${{Postgres.PGDATABASE}}
DB_USERNAME=${{Postgres.PGUSER}}
DB_PASSWORD=${{Postgres.PGPASSWORD}}

# Security
CORS_ALLOWED_ORIGINS=https://yourfrontend.com
API_RATE_LIMIT=100
SECURITY_HSTS_ENABLED=true
TRUST_PROXIES=true
```

See [DEPLOYMENT.md](DEPLOYMENT.md) for complete configuration details.

## 🏗️ Tech Stack

- **Framework:** Laravel 13
- **Database:** PostgreSQL 15
- **Admin Panel:** Filament 4
- **Deployment:** Railway (Nixpacks)
- **CI/CD:** Railway automatic deployments
- **PHP Version:** 8.4

## 📁 Project Structure

```
app/
├── Actions/          # Single-purpose action classes
├── Http/
│   ├── Controllers/  # API controllers
│   └── Middleware/   # Custom middleware (Security, CORS)
├── Models/          # Eloquent models
└── Services/        # Business logic layer

config/
├── cors.php         # CORS configuration
└── ...

routes/
└── api.php          # API routes

.github/
└── workflows/
    └── deploy-railway.yml  # Deployment workflow
```

## 🤝 Contributing

This is a personal portfolio API. If you find issues or have suggestions, feel free to open an issue.

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 🙏 Acknowledgments

- Built with [Laravel](https://laravel.com)
- Admin panel powered by [Filament](https://filamentphp.com)
- Deployed on [Railway](https://railway.app)

