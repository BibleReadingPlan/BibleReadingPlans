<?php
/**
 * Bootstrap for BibleReadingPlans test suite.
 *
 * Works in two environments:
 *
 *  - wp-env (Docker): WP_TESTS_DIR is pre-set to /wordpress-phpunit inside the
 *    tests-cli container. WordPress, the test DB, and the test library are all
 *    managed by wp-env.
 *
 *  - Local (no wp-env): WP_TESTS_DIR is not set, so we fall back to the
 *    vendored wp-phpunit/wp-phpunit package. A working WordPress installation
 *    and a test database must be configured in wp-tests-config.php.
 *
 * API keys are read from environment variables (BRP_DBP_KEY, BRP_ABS_KEY,
 * BRP_ESV_KEY). When running via wp-env they can be supplied via
 * .wp-env.override.json as wp-config.php constants; this bootstrap promotes
 * those constants to env vars so the test classes need not change.
 */

declare(strict_types=1);

// Tell the WP test bootstrap where to find our vendored PHPUnit Polyfills.
define('WP_TESTS_PHPUNIT_POLYFILLS_PATH',
    dirname(__DIR__) . '/vendor/yoast/phpunit-polyfills');

// Locate the WP test library: wp-env sets WP_TESTS_DIR; otherwise use vendor.
$_tests_dir = (string) (getenv('WP_TESTS_DIR')
    ?: dirname(__DIR__) . '/vendor/wp-phpunit/wp-phpunit');

// Load WP test helper functions (defines tests_add_filter, etc.) so we can
// register our plugin loader before the main bootstrap fires.
require_once $_tests_dir . '/includes/functions.php';

// Load the plugin class once WordPress has been bootstrapped.
function _brp_load_plugin(): void {
    require_once dirname(__DIR__) . '/bible-reading-plans-class.inc.php';
}
tests_add_filter('muplugins_loaded', '_brp_load_plugin');

// Boot the full WP test environment (installs WordPress, sets up DB, loads WP).
require $_tests_dir . '/includes/bootstrap.php';

// wp-env writes API keys into wp-config.php as define() constants when they
// are listed under "config" in .wp-env.override.json. Promote any such
// constants to environment variables so the test classes can still use getenv().
foreach (['BRP_DBP_KEY', 'BRP_ABS_KEY', 'BRP_ESV_KEY'] as $_brp_key) {
    if (!getenv($_brp_key) && defined($_brp_key)) {
        putenv($_brp_key . '=' . constant($_brp_key));
    }
}
unset($_brp_key);

// Load our test helper (BibleReadingPlans must already be defined at this point).
require_once __DIR__ . '/class-brp-test-helper.php';
