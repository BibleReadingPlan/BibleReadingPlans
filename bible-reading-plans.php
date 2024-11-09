<?php
/**
 * @package				BibleReadingPlans
 * @version				3.0.3
 * @license				GPLv3 or later
 *
 * @wordpress-plugin
 * Plugin Name:			Bible Reading Plans
 * Plugin URI:			https://www.sitewidgets.com/bible-reading-plans/
 * Description:			This plugin provides the ability to embed Bible reading plans into a post or page using shortcode of the form <code>[bible-reading-plan source="DBP" reading_plan="mcheyne" bible_id="ENGNAS" bible_all_audio_id="" bible_ot_audio_id="" bible_nt_audio_id=""]</code>. **The last three parameters are new Version 3.0 and provide access to audio versions of the Scriptures, this shortcode applies only to the DBP source and *provides access to over 2000 Bible versions in nearly 1900 languages,* with more versions and languages being added regularly.** Three sources for the Scriptures displayed for each plan are available: American Bible Society API, Version 1 (API.Bible), The Bible Brain (aka Digital Bible Platform) API, Version 4 (faithcomesbyhearing.com/bible-brain/developer-documentation), and the ESV Bible Web Service API, Version 3 (api.esv.org). There are 16 different Bible reading plans available with the plugin, plus the ability to create ones own reading plan using an auxiliary, premium plugin.

 * Version:				3.0.3
 * Requires at least:	2.8
 * Tested up to:		6.6.2
 * Requires PHP: 		5.6
 * Tested up to PHP:	8.3
 * Contributors: 		drmikegreen, sophoservices
 * Contributors URI: 	https://www.saesolved.com/, https://sophoservices.com/
 * Text Domain: 		bible-reading-plans
 * License: 			GPLv3 or later
 * License URI:			http://www.gnu.org/licenses/gpl-3.0.html
 * Plugin URI: 			https://www.saesolved.com/bible-reading-plans/
 */

/*

This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.
*/

	include_once('bible-reading-plans-class.inc.php');
	include_once('bible-reading-plans-hooks.inc.php');

?>
