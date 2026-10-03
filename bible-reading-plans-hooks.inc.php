<?php
add_action('init', 'bible_reading_plans_init');
function bible_reading_plans_init() {
	if (class_exists('BibleReadingPlans')) {
		$brp = new BibleReadingPlans();
		if (version_compare(PHP_VERSION, '5.0.0', '<')) {
		    $brp = &$brp;
        }
		if (isset($brp)) {
			if (is_admin()) { // http://codex.wordpress.org/AJAX_in_Plugins#Ajax_on_the_Viewer-Facing_Side
				add_action('wp_ajax_add_css_and_scripts', 			array($brp, 'addCSSAndScripts'));
				add_action('wp_ajax_put_bible_reading_plan',		array($brp, 'putBibleReadingPlan'));
				add_action('wp_ajax_nopriv_add_css_and_script', 	array($brp, 'addCSSAndScripts'));
				add_action('wp_ajax_nopriv_put_bible_reading_plan',	array($brp, 'putBibleReadingPlan'));
				add_action('admin_menu', 							array($brp, 'adminAddPage'));
				add_action('admin_footer',							array($brp, 'addLanguagesAndVersions'));
				add_action('wp_ajax_put_languages_and_versions',	array($brp, 'putLanguagesAndVersions'));
				add_action('wp_ajax_dbp_versions_list',				array($brp, 'dbpVersionsList'));
				if (FALSE !== strpos($_SERVER["REQUEST_URI"], '/wp-admin/options-general.php?page=bible_reading_plans_plugin') || '/wp-admin/options.php' == $_SERVER["REQUEST_URI"]) {
					// Only load Bible Reading Plans admin methods when the Bible Reading Plans option in the settings is active.
					add_action('admin_init', 						array($brp, 'initializeAdmin'));
					add_action('admin_enqueue_scripts', 				array($brp, 'addCSSAndScripts'), 98);
				}
			} else {
				add_filter('the_content',	array($brp, 'removePreTags'));
				add_action('wp_head',   	array($brp, 'addCSSAndScripts'), 99);
				add_action('wp_footer', 	array($brp, 'addScriptureLoader'), 98);
			}
		}
	}
}
?>
