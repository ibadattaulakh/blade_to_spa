# Testing Guide: Episode 47 Setup Verification

This document outlines how to verify that everything from Episode 47 is implemented correctly.

## Quick Verification

Run the automated verification script:

```bash
php verify-setup.php
```

## Manual Verification Steps

### 1. Format Script Configuration ✅

**Test:** Verify the format script runs both Rector and Pint

```bash
composer run format
```

**Expected Output:**
- Rector processes files and shows completion message
- Pint formats files and shows "PASS" for all files
- No errors

**What to Check:**
- `composer.json` should have: `"format": "vendor/bin/rector process && vendor/bin/pint"`

### 2. Rector Configuration ✅

**Test:** Verify Rector is properly configured

```bash
vendor/bin/rector process
```

**What to Check:**
- `rector.php` exists
- Configures paths: `app/`, `routes/`, `tests/`
- Has skip rules for closure return types (to avoid breaking test closures)
- Uses prepared sets: deadCode, codeQuality, codingStyle, typeDeclarations, etc.

### 3. Pint Configuration ✅

**Test:** Verify Pint is properly configured

```bash
vendor/bin/pint --test
```

**Expected Output:**
- Shows "PASS" for all files
- No formatting changes needed (code is already formatted)

### 4. Test Suite ✅

**Test:** Run the test suite to ensure nothing broke

```bash
php artisan test
# or for feature tests only:
php artisan test --testsuite=Feature
```

**Expected Results:**
- ✅ 14 feature tests pass
- ⚠️ Browser tests may fail if Playwright is outdated (not a code issue)

**What to Check:**
- `phpunit.xml` has correct test suites (Feature, Browser)
- No "unit" test suite that doesn't exist

### 5. Routes Configuration ✅

**Test:** Verify routes are properly configured

```bash
php artisan route:list
```

**What to Check:**
- Dev helper routes (`/dev/login`, `/dev/logout`) are present in non-production
- Dev routes are guarded with `if (! app()->isProduction())`
- All expected routes are registered:
  - Homepage (`/`)
  - Posts routes (`/home`, `/posts`, etc.)
  - Profile routes (`/{profile:handle}`, etc.)
  - Post actions (like, repost, quote, reply, etc.)

### 6. Dev Routes Security ✅

**Test:** Verify dev routes are properly guarded

**Check `routes/web.php`:**
```php
if (! app()->isProduction()) {
    Route::get('/dev/login', ...);
    Route::get('/dev/logout', ...);
}
```

**What to Verify:**
- Dev routes are wrapped in `! app()->isProduction()` check
- This ensures they never appear in production
- `app()->isProduction()` checks if `APP_ENV=production`

### 7. Git Status ✅

**Test:** Check if formatting made any changes

```bash
git status
```

**Expected:**
- Working tree should be clean (or only show expected changes)
- If formatting made changes, review them before committing

## Complete Test Checklist

- [x] Format script runs successfully (`composer run format`)
- [x] Rector is installed and configured
- [x] Pint is installed and configured
- [x] PHPUnit configuration is correct
- [x] Feature tests pass (14/14)
- [x] Routes are properly configured
- [x] Dev helper routes are guarded
- [x] Code is properly formatted (Pint passes)
- [x] Code is modernized (Rector processes successfully)

## Troubleshooting

### Format script fails
- Check that both `vendor/bin/rector` and `vendor/bin/pint` exist
- Run `composer install` if binaries are missing

### Tests fail
- Check `phpunit.xml` for incorrect test suite references
- Ensure database is set up (SQLite for testing)
- Run `php artisan config:clear` if configuration issues

### Dev routes appear in production
- Verify `APP_ENV` is set to `production` in production
- Check that `routes/web.php` uses `! app()->isProduction()`

### Rector makes unwanted changes
- Review `rector.php` skip rules
- Add rules to skip in `withSkip()` array
- Run `composer run format` again after adjusting

## Summary

All Episode 47 requirements are verified:

✅ **Format Script:** Combined Rector + Pint command  
✅ **Rector:** Configured with proper paths and skip rules  
✅ **Pint:** Installed and formatting code correctly  
✅ **Tests:** Feature tests passing, PHPUnit configured correctly  
✅ **Routes:** Properly configured with dev route guards  
✅ **Code Quality:** Code is formatted and modernized  

The codebase is ready for development!
