#!/usr/bin/env php
<?php

/**
 * Verification script to test that everything from Episode 47 is set up correctly
 */

echo "🔍 Verifying Episode 47 Setup...\n\n";

$errors = [];
$warnings = [];
$success = [];

// 1. Check composer.json format script
echo "1. Checking format script configuration...\n";
$composerJson = json_decode(file_get_contents(__DIR__.'/composer.json'), true);
if (isset($composerJson['scripts']['format'])) {
    $formatScript = $composerJson['scripts']['format'];
    if (is_string($formatScript) && str_contains($formatScript, 'rector') && str_contains($formatScript, 'pint')) {
        $success[] = "✓ Format script is correctly configured";
    } else {
        $errors[] = "✗ Format script should be a string with 'rector process && pint'";
    }
} else {
    $errors[] = "✗ Format script not found in composer.json";
}

// 2. Check Rector configuration
echo "2. Checking Rector configuration...\n";
if (file_exists(__DIR__.'/rector.php')) {
    $rectorConfig = file_get_contents(__DIR__.'/rector.php');
    if (str_contains($rectorConfig, 'withPaths') && str_contains($rectorConfig, 'withSkip')) {
        $success[] = "✓ Rector config file exists with paths and skip rules";
    } else {
        $warnings[] = "⚠ Rector config exists but may be missing paths or skip rules";
    }
} else {
    $errors[] = "✗ rector.php configuration file not found";
}

// 3. Check Pint is installed
echo "3. Checking Pint installation...\n";
if (file_exists(__DIR__.'/vendor/bin/pint')) {
    $success[] = "✓ Pint is installed";
} else {
    $errors[] = "✗ Pint binary not found. Run: composer install";
}

// 4. Check Rector is installed
echo "4. Checking Rector installation...\n";
if (file_exists(__DIR__.'/vendor/bin/rector')) {
    $success[] = "✓ Rector is installed";
} else {
    $errors[] = "✗ Rector binary not found. Run: composer install";
}

// 5. Check PHPUnit configuration
echo "5. Checking PHPUnit configuration...\n";
if (file_exists(__DIR__.'/phpunit.xml')) {
    $phpunitXml = file_get_contents(__DIR__.'/phpunit.xml');
    // Check that there's no "unit" test suite that doesn't exist
    if (str_contains($phpunitXml, '<testsuite name="Feature">') && 
        str_contains($phpunitXml, '<testsuite name="Browser">')) {
        if (!str_contains($phpunitXml, '<testsuite name="unit">') && 
            !str_contains($phpunitXml, '<testsuite name="Unit">')) {
            $success[] = "✓ PHPUnit config has correct test suites (Feature, Browser)";
        } else {
            $warnings[] = "⚠ PHPUnit config may reference a 'unit' test suite that doesn't exist";
        }
    }
} else {
    $errors[] = "✗ phpunit.xml not found";
}

// 6. Check dev routes are properly guarded
echo "6. Checking dev routes are properly guarded...\n";
$webRoutes = file_get_contents(__DIR__.'/routes/web.php');
if (str_contains($webRoutes, "if (! app()->isProduction())")) {
    $success[] = "✓ Dev helper routes are guarded with isProduction() check";
} else {
    $warnings[] = "⚠ Dev helper routes may not be properly guarded";
}

// 7. Check routes file exists and is readable
echo "7. Checking routes configuration...\n";
if (file_exists(__DIR__.'/routes/web.php')) {
    $success[] = "✓ Routes file exists";
} else {
    $errors[] = "✗ routes/web.php not found";
}

// Print results
echo "\n" . str_repeat("=", 50) . "\n";
echo "RESULTS:\n";
echo str_repeat("=", 50) . "\n\n";

if (!empty($success)) {
    echo "✅ SUCCESS:\n";
    foreach ($success as $msg) {
        echo "   $msg\n";
    }
    echo "\n";
}

if (!empty($warnings)) {
    echo "⚠️  WARNINGS:\n";
    foreach ($warnings as $msg) {
        echo "   $msg\n";
    }
    echo "\n";
}

if (!empty($errors)) {
    echo "❌ ERRORS:\n";
    foreach ($errors as $msg) {
        echo "   $msg\n";
    }
    echo "\n";
    exit(1);
}

echo "🎉 All checks passed! Setup is correct.\n\n";
echo "Next steps to verify:\n";
echo "  1. Run: composer run format\n";
echo "  2. Run: php artisan test\n";
echo "  3. Run: php artisan route:list (verify dev routes exist in non-production)\n";
echo "  4. Check git status to see if formatting made any changes\n";

exit(0);
