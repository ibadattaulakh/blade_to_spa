# Deployment Guide

This guide covers deploying the Pixl application using Laravel Forge.

## Pre-Deployment Checklist

### 1. Prepare Repository
- Ensure all changes are committed
- Run code formatters:
  ```bash
  composer format
  ```
- Push clean commit:
  ```bash
  git add .
  git commit -m "Migrate To Vue And Inertia"
  git push origin main
  ```

### 2. Forge Server Setup

1. **Create Server**
   - Use Laravel VPS provider (small instance is fine for demo)
   - Download SSH credentials (shown once only - save them!)

2. **Create Site**
   - Point to your GitHub repository
   - Select the branch to deploy (usually `main`)
   - Set up domain/subdomain

### 3. Environment Configuration

In Forge → Site → Environment, set:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

DB_CONNECTION=sqlite
# For SQLite, other DB env values can be left commented out

# Or for MySQL:
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=forge
# DB_USERNAME=forge
# DB_PASSWORD=your-password
```

### 4. Deploy Script

Ensure your Forge deploy script includes:

```bash
cd /home/forge/your-domain.com/releases/<release>

# Install PHP dependencies
composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

# Build frontend assets (CRITICAL for Vite)
npm ci
npm run build

# Run migrations
php artisan migrate --force

# Cache configuration
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

**Important:** The `npm run build` step is critical - without it, you'll get "Vite manifest not found" errors.

### 5. Database Setup

#### Option A: Run Seeder (Recommended)
```bash
php artisan db:seed
```

This creates 20 profiles with posts, follows, likes, and reposts.

#### Option B: Create User via Tinker
If you need a specific user for demo:

```bash
php artisan tinker
```

```php
$user = new \App\Models\User();
$user->email = 'demo@example.com';
$user->password = bcrypt('your-secure-password');
$user->save();

$user->profile()->create([
    'display_name' => 'Demo User',
    'handle' => 'demo',
    'bio' => 'Demo account',
]);
```

### 6. Temporary Dev Login (Demo Only)

The application includes a dev login route for demo purposes:

```php
// routes/web.php
if (! app()->isProduction()) {
    Route::get('/dev/login', function () {
        $user = User::first();
        Auth::login($user);
        return redirect()->route('profiles.show', $user->profile);
    })->name('login');
}
```

**⚠️ IMPORTANT:** This route is automatically disabled in production (`app()->isProduction()`). Remove it entirely before making the site production-ready.

### 7. Common Deployment Issues

#### Vite Manifest Not Found
**Symptom:** 500 error, "Vite manifest not found"

**Solution:**
1. Check deploy log in Forge → Site → Deployments
2. Verify `npm run build` completed successfully
3. Ensure Node.js version is compatible
4. Check for npm dependency errors
5. Manually run build if needed:
   ```bash
   cd /home/forge/your-domain.com/current
   npm ci
   npm run build
   ```

#### Empty Database
**Symptom:** Dev login fails, no users exist

**Solution:**
- Run database seeder: `php artisan db:seed`
- Or create user via Tinker (see above)

#### Environment Variables Not Set
**Symptom:** Config errors, missing APP_KEY

**Solution:**
- Set all required env vars in Forge → Site → Environment
- Run `php artisan config:cache` after changes

### 8. Post-Deployment Verification

1. Visit homepage - should show marketing page
2. Click "Sign in" - should log in via dev route (if not production)
3. Verify timeline loads posts
4. Test follow/unfollow functionality
5. Test creating a post
6. Verify flash messages appear

### 9. Security Checklist

Before making site production-ready:

- [ ] Remove `/dev/login` route entirely
- [ ] Remove `/dev/logout` route entirely
- [ ] Implement proper authentication flow
- [ ] Set `APP_DEBUG=false` in production
- [ ] Use secure database credentials
- [ ] Enable HTTPS/SSL certificate
- [ ] Review and secure environment variables
- [ ] Set up proper error logging
- [ ] Configure queue workers if using queues
- [ ] Set up backup strategy

### 10. Forge Deploy Script Template

Here's a complete deploy script template for Forge:

```bash
cd /home/forge/your-domain.com/releases/<release>

# Install dependencies
composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev
npm ci

# Build assets
npm run build

# Run migrations
php artisan migrate --force

# Cache everything
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Restart queue workers (if using queues)
# php artisan queue:restart
```

### Notes

- The dev login route (`/dev/login`) is automatically disabled in production
- Database seeder creates realistic test data (20 profiles, posts, follows, likes)
- Vite assets must be built during deployment (`npm run build`)
- SQLite is fine for demo, but use MySQL/PostgreSQL for production
- Always test deployment on staging environment first
