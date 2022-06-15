<?php
if (class_exists('BibleReadingPlans')) {
	$bible_reading_plan = new BibleReadingPlans();
	if (isset($bible_reading_plan)) {
		if (is_admin()) { // http://codex.wordpress.org/AJAX_in_Plugins#Ajax_on_the_Viewer-Facing_Side
			add_action('wp_ajax_add_css_and_scripts', 			array(&$bible_reading_plan, 'addCSSAndScripts'));
			add_action('wp_ajax_put_bible_reading_plan',		array(&$bible_reading_plan, 'putBibleReadingPlan'));
			add_action('wp_ajax_nopriv_add_css_and_script', 	array(&$bible_reading_plan, 'addCSSAndScripts'));
			add_action('wp_ajax_nopriv_put_bible_reading_plan',	array(&$bible_reading_plan, 'putBibleReadingPlan'));
			add_action('admin_menu', 							array(&$bible_reading_plan, 'adminAddPage'));
			add_action('admin_footer',							array(&$bible_reading_plan, 'addLanguagesAndVersions'));
			add_action('wp_ajax_put_languages_and_versions',	array(&$bible_reading_plan, 'putLanguagesAndVersions'));
			add_action('wp_ajax_dbp_versions_list',				array(&$bible_reading_plan, 'dbpVersionsList'));
			if (FALSE !== strpos($_SERVER["REQUEST_URI"], '/wp-admin/options-general.php?page=bible_reading_plans_plugin') || '/wp-admin/options.php' == $_SERVER["REQUEST_URI"]) {
				// Only load Bible Reading Plans admin methods when the Bible Reading Plans option in the settings is active.
				add_action('admin_init', 						array(&$bible_reading_plan, 'initializeAdmin'));
				add_action('admin_enqueue_scripts', 			array(&$bible_reading_plan, 'addCSSAndScripts'), 98);
			}
		} else {
			add_filter('the_content',	array(&$bible_reading_plan, 'removePreTags'));
			add_action('wp_head',   	array(&$bible_reading_plan, 'addCSSAndScripts'), 99);
			add_action('wp_footer', 	array(&$bible_reading_plan, 'addScriptureLoader'), 98);
		}
	}
}
?>
