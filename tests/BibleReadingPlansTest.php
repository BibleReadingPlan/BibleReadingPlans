<?php

// Mock WordPress functions
if (!function_exists('plugin_dir_url')) { function plugin_dir_url($file) { return ''; } }
if (!function_exists('plugin_dir_path')) { function plugin_dir_path($file) { return __DIR__ . '/../'; } }
if (!function_exists('__')) { function __($text, $domain = 'default') { return $text; } }
if (!function_exists('_e')) { function _e($text, $domain = 'default') { echo $text; } }
if (!function_exists('get_option')) { function get_option($option) { return false; } }
if (!function_exists('update_option')) { function update_option($option, $value) { return true; } }
if (!function_exists('delete_option')) { function delete_option($option) { return true; } }
if (!function_exists('wp_remote_get')) { function wp_remote_get($url, $args) { return array(); } }
if (!function_exists('is_admin')) { function is_admin() { return false; } }

// Include the class
require_once __DIR__ . '/../bible-reading-plans-class.inc.php';

class BibleReadingPlansTest extends BibleReadingPlans {
    public function __construct() {
        // Manually load properties. 
        // We need to ensure the current directory is correct for the require_once calls in load_property_values
        // load_property_values uses relative paths like 'includes/properties/...'
        // So we should probably change directory or ensure we run from root.
        // But here we can just call it and hope the runner sets CWD correctly.
        // Alternatively, we can override load_property_values to fix paths, but that changes the code being tested.
        
        // Let's assume the script is run from the project root.
        $this->load_property_values();
    }

    public function expose_get_book_name_for_language_being_used_dbp($decoded_text, $book_english) {
        return $this->get_book_name_for_language_being_used_dbp($decoded_text, $book_english);
    }
}

// Test Execution
echo "Running Test: Validate Psa turns into Psalms\n";

// Change directory to project root so that relative includes in load_property_values work
chdir(__DIR__ . '/../');

$tester = new BibleReadingPlansTest();

// Test Case 1: User request "Psa"
// Note: "Psa" is not a standard key in book_codes_names, but let's see what happens given the code logic.
$decoded_text = array(
    'data' => array(
        0 => array(
            'book_id' => 'Psa',
            'book_name' => 'Original Name',
            // 'book_name_alt' => 'Alt Name' // Removed to force logic usage
        )
    )
);
$book_english = 'Some English Name';

$result = $tester->expose_get_book_name_for_language_being_used_dbp($decoded_text, $book_english);
echo "Case 'Psa': Expected 'Psalms', Got '$result'\n";

// Test Case 2: 'PSA' (Standard code)
$decoded_text['data'][0]['book_id'] = 'PSA';
$result = $tester->expose_get_book_name_for_language_being_used_dbp($decoded_text, $book_english);
echo "Case 'PSA': Expected 'Psalms', Got '$result'\n";

// Test Case 3: 'GEN' (Should NOT be Psalms, but code might be buggy)
$decoded_text['data'][0]['book_id'] = 'GEN';
$result = $tester->expose_get_book_name_for_language_being_used_dbp($decoded_text, $book_english);
echo "Case 'GEN': Expected 'Genesis' (or Original Name), Got '$result'\n";

