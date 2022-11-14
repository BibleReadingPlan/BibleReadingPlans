=== Bible Reading Plans ===
Contributors: drmikegreen, sophoservices
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=3GNC36MKM6ADC&source=url
Tags: Bible reading plans, shortcode, Bible, daily readings, Bible Brain, Digital Bible Platform, American Bible Society, API.Bible, api.esv.org
Requires at least: 2.8
Tested up to: 6.1
Requires PHP: 5.6
Tested up to PHP: 7.4
Stable tag: trunk
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Provides the ability to embed Bible Reading Plans into a post or page using a shortcode.

== Description ==

This plugin provides the ability to embed Bible reading plans into a post or page using shortcode of the form <code>[bible-reading-plan reading_plan="mcheyne" source="DBP" version="ESV"]</code> or <code>[bible-reading-plan reading_plan="mcheyne" source="DBP" bible_id="ENGESV"]</code>. **The latter form is new in this version, applies only to the DBP source, and *provides access to over 1700 Bible versions in more than 1500 languages,* with more versions and languages being added regularly.** Three sources for the Scriptures displayed for each plan are available: American Bible Society API, Version 1 (API.Bible), The Bible Brain (aka Digital Bible Platform) API, Version 4 (faithcomesbyhearing.com/bible-brain/developer-documentation), and the ESV Bible Web Service API, Version 3 (api.esv.org). See the screenshots for an example of how to use this plugin. 

This plugin is a fork of the Embed Bible Passages plugin (https://wordpress.org/plugins/embed-bible-passages/) made necessary by changes in the ESV Bible Web Service API. (Version 2 included Bible reading plans, but is deprecated and was terminate completely on 15 April 2021. Version 3 is the only version available to new users, but does not include Bible reading plans.) Since the American Bible Society API provides more than 20 English language versions (with the potential for more via the Digital Bible Library to acquire the necessary licenses) and over 1600 languages and the Bible Brain API provides 10 English versions and access to over 1700 Bible versions in more than 1500 languages. In addition it has the potential for audio and video for many of the versions. We hope this fork promises a much broader future than did the Embed Bible Passages plugin. The ESV Bible Web Service API, Version 3, however, has also been included in this plugin because it provides audio directly with the texts as well as better formatting control, even though it naturally provides only the English Standard Version.

If the "Display Plan Name on Pages" on the settings page is unchecked, the page displayed to the public will all be in the language of the bible_id used in the shortcode, with the exception of the copyright information and potentially the calendar.

It is hoped that persons with skills in other languages will come forward to localize this plugin for the available languages. (I.e., Translate things like the instructions on the "Settings" page, the reading plan names, and copyright statements.)

The values of reading_plan can be:
        	
	back-to-the-bible-chronological - Back to the Bible Chronological
	bcp19-acna-evening - Book of Common Prayer, 2019, Anglican Church in North America -- Evening Prayer
	bcp19-acna-morning - Book of Common Prayer, 2019, Anglican Church in North America -- Morning Prayer
	bcp19-acna-twoyear - Book of Common Prayer, 2019, Anglican Church in North America -- Two Year Plan 
	chronicles-and-prophets - Chronicles and Prophets
	daily-light-on-the-daily-path-evening - Daily Light on the Daily Path -- Evening
	daily-light-on-the-daily-path-morning - Daily Light on the Daily Path -- Morning
	every-day-in-the-word - Every Day In the Word
	gospels-and-epistles - Gospel and Epistles
	heart-light-ot-and-nt - Heartlight Old and New Testament
	lsb - Literary Study Bible
	mcheyne - M'Cheyne One-Year Reading Plan
	one-year-chronological - One Year Chronological
	pentateuch-and-history-of-israel - Pentateuch and History of Israel
	psalms-and-wisdom-literature - Psalms and Wisdom Literature
	through-the-bible - Through the Bible in a Year

The default reading plan is M'Cheyne One-Year Reading Plan. 

We may add more plans in the future, but have created a premium plugin "Create Bible Reading Plans" (https://sllwi.re/p/1Il) to make it possible to create one's own Bible reading plan for use in this plugin.

The values of source can be:

    ABS - American Bible Society (API.Bible)
    DBP - Bible Brain (aka Digital Bible Platform) (faithcomesbyhearing.com/bible-brain/developer-documentation)
    ESV - ESV Bible Web Service API (api.esv.org)

The default source is DBP.

(Note that, in order to use these sources, you must obtain Access Keys from the American Bible Society, the Bible Brain, and/or the ESV Bible Web Service API. Instructions for doing so are on the Settings page for the plugin.)

If the source is ABS, the values of version can, at present, be:
        	
    ASV - American Standard Version
    LXXup - Brenton English Septuagint (Updated Spelling and Formatting)
    Brenton - Brenton English translation of the Septuagint
    KJVCPB - Cambridge Paragraph Bible of the KJV
    DRA - Douay-Rheims American 1899
    EMTV - English Majority Text Version
    FBV - Free Bible Version
    GNV - Geneva Bible
    OJPS - JPS TaNaKH 1917 (Old Testament only)
    KJV-E - King James (Authorised) Version, Ecumenical
    KJV-P - King James (Authorised) Version, Protestant
    RV - Revised Version 1885
    F35 - The English New Testament According to Family 35
    T4T - Translation for Translators
    WEBBE-C - World English Bible British Edition, Catholic
    WEBBE-E - World English Bible British Edition, Ecumenical
    WEBBE-O - World English Bible British Edition, Orthodox
    WEBBE-P - World English Bible British Edition, Protestant
    WEB-C - World English Bible, Catholic
    WEB-E - World English Bible, Ecumenical
    WEB-O - World English Bible, Orthodox
    WEB-P - World English Bible, Protestant
    WMB - World Messianic Bible
    WMBBE - World Messianic Bible British Edition

The default verson is KJV-P.

If the source is DBP, the English language values of the version can, at present, be:

    ENGASV - American Standard Bible
	ENGESV - English Standard Version®
	ENGEVD - English Version for the Deaf
	ENGKJV - King James Version
	ENGNAS - New American Standard Bible (NASB)
	ENGNLV - New Life Version (Easy to Read) (New Testament)
	ENGREV - Revised Version 1885
	ENGWEB - World English Bible
	ENGWM1 - World Messianic Version
	ENGWMV - Wycliffe Modern

The default version is ENGESV.

In addition DBP source provides over 1700 Bible versions in more than 1500 languages, with more versions and languages being added regularly.

If the source is ESV, the value of the version naturally can only be ESV.

The page opens with the plan reading for the current date, as set on the client computer. An optional date picker calendar is available to enable users to choose readings for other dates.

See [Gospel and Epistles](https://ogbcashdown.org/gospel-and-epistles-bible-reading-plan/) and other reading plans on that site, the [Daily Office at Habits of Grace](https://habitsofgrace.org/), and the test pages at [Test Site For SaeSolved:: Software](https://test.sitewidgets.com/) for example implementations of this plugin.

This plugin requires JavaScript to be active.

== License ==

This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

== Installation ==

1. Extract the embed-bible-passages folder and place in the wp-content/plugins folder. Enable the plugin.

1. Request Access Keys from the American Bible Society, the Bible Brain,  and/or the ESV Bible Web Service API using the links given on the settings page.

1. Enter those Access Keys in their fields in the Bible Reading Plans Settings.

1. Select whether or not to display plan names on pages.

1. Select whether or not to provide the ability for users to select passages for days other than the current day by clicking on a calendar and where to place that calendar.

1. Select whether or not to optionally show a "Powered by" attribution at the bottom of pages.

1. Create pages and/or posts containing the shortcode of the form <code>[bible-reading-plan reading_plan="mcheyne" source="DBP" version="ESV"]</code> or <code>[bible-reading-plan reading_plan="mcheyne" source="DBP" bible_id="ENGESV"]</code>. (It is recommended that the shortcode be placed in a shortcode block when using the WordPress Gutenberg Editor.)

NOTE THAT THE COPYRIGHT NOTICE FROM THE SOURCE OF THE TEXT MUST BE KEPT ON THE PAGE.

== Screenshots ==

1. Sample input for page of Daily Light on the Daily Path -- Morning Plan.

2. Sample result for page of Daily Light on the Daily Path -- Morning Plan.

3. Settings page part 1.

4. Settings page part 1 open to French DBP versions.

5. Settings page part 2.

6. Sample result for page of a reading plan in French.

== Upgrade Notice ==

= 2.1.3 =

This version:

1. Registers Display Table of Contents on Pages settings.

1. Corrects link to Create Bible Reading plans to https://sllwi.re/p/1Il.

= 2.1.2 =

This version:

1. Makes first day of week for the calendar that of the first day of the week set in the WordPress options for English calendars (the script for the calendar for other languages set this).

1. Adds screenshot of Create Bible Readings Plans plugin settings screen to text linking to that plugin.

1. Bug fix: Corrects Table of Contents so that it now displays in the language of the page.

1. Bug fix: Corrects heading for first Scripture readings to be only for the language of the page, instead of a combination of that language and English.

1. Bug fixes: Corrects Scripture references for Book of Common Prayer, 2019, Anglican Church in North America -- Evening Prayer for 7 and 22 October.

1. Bug fix: Makes Table of Contents text be aligned center, as originally intended.

1. Bug fix: Corrects repetition of Apocryphal books.

= 2.1.1 =

This version updates the .pot languages file.

= 2.1 =

This version:

1. Adds a floating table of contents.

1. Corrects typo on line 1460 of bible-reading-plans-class.inc.php of version 2.0.2.

1. Restructures some code for easier maintenance.

= 2.0.2 =

This version:

1. Moves call to method which checks on whether or not there are any new reading plans from the method which initializes the administrative settings to the __construct() method in order to make sure all new or corrected plans are available even if the administrative settings are not accessed after an upgrade.


1. Corrects Scripture references in a number of places where the references were from a specific verse to the end of the chapter for the Book of Common Prayer, 2019, Anglican Church in North America. These references weren't being handled correctly for the ESV API.

= 2.0.1 =

This version:

1. Corrects problem with the AJAX call that was causing a conflict with some other plugins.

1. Corrects Scripture reference for Book of Common Prayer, 2019, Anglican Church in North America -- Evening Prayer for 23 June.

= 2.0 =

This version:

1. Adds access to over 1700 versions in more than 1500 languages via the Bible Brain (aka the Digital Bible Platform) API.

1. Provides on-the-fly conversion of plans created by the Create Bible Reading Plans plugins to Version 4 of the Bible Brain (aka Digital Bible Platform) API.

1. Corrects the URL for the ESV Scriptures source.

1. Corrects an error in CSS class brp-no-readings -- there was a colon where there should have been a semi-colon.

1. Adds a statement to CSS class brp-no-readings -- "padding-left: 10.5em !important;" to class eb-container .p1,

1. Corrects certain places that Scripture references were repeated.

= 1.1.3 =

This version:

1. Removes <pre> tags some themes place around the shortcode, causing the text to not wrap.

= 1.1.2 =

This version:

1. Corrects yet another problem with rendering proper Scriptures when the reference is a book with only one chapter.

1. Corrects a problem with rendering Jeremiah 35:1-36:32 properly on 20 October for the "Every Day In the Word" plan.

= 1.1.1 =

1. This version corrects additional problem with rendering proper Scriptures when the reference is a book with only one chapter.

= 1.1 =

This version:

1. Is a significant code re-write in order to implement Version 4 of the Bible Brain (aka Digital Bible Platform) API.

1. Corrects problem with rendering proper Scriptures when the reference is a book with only one chapter.

1. Provides more appropriate formatting for poetic books from the Bible Brain (aka Digital Bible Platform) API.

= 1.0.8 =

This version:

1. Fixes bug which was inhibiting plugin activation.

1. Adds Plugin URI to help with potential conflicts with other plugins.

1. Changes Text Domain to bible-reading-plans (from bible_reading_plans).

= 1.0.7 =

This version:

1. Corrects problem with rendering proper Scriptures when the reference spans more than one chapter (e.g, 2 Kings 8:1-9:13).

1. Corrects Scripture reference for Book of Common Prayer, 2019, Anglican Church in North America -- Morning Prayer for 2 June.

= 1.0.6 =

This version:

1. Corrects problem of Firefox not playing audio.

1. Corrects Scripture reference for Book of Common Prayer, 2019, Anglican Church in North America -- Morning Prayer for 17 May.

1. Makes further improvements to the spacing of headings and wrapping of text around calendar in Scriptures from esv.org.

1. Fixes bugs -- Scripture references which are just book and chapter (no verses specified) and undefined variable "$heading."

= 1.0.5 =

This version:

1. Fixes conflict with the Elementor plugin.

1. Corrects Scripture reference for Book of Common Prayer, 2019, Anglican Church in North America -- Morning Prayer for 5 May.

1. Improves wrapping of Psalm titles around calendar (when calendar in text option is selected) for Scriptures from esv.org.

= 1.0.4 =

This version:

1. Fixes issue with calendar not appearing on mobile phones or above Scriptures (when that option is selected).

1. Corrects wrapping of text around calendar (when calendar in text option is selected) for Scriptures from esv.org.

1. Corrects Scripture references for Every Day in the Word Psalms for 27 April.

= 1.0.3 =

1. This version fixes conflict with WordFence firewall blocks when Yoast SEO plugin is also active.

= 1.0.2 =

1. This version actually uploads the corrected Every Day in the Word reading plan.

= 1.0.1 =

1. This version corrects errors in the Every Day in the Word reading plan.

= 1.0 =

This version:

1. adds the reading plans "Chronicles and Prophets," "Gospel and Epistles," "Pentateuch and History of Israel," and "Psalms and Wisdom Literature."

1. enhances the text from esv.org by including passage headings.

1. corrects one of the Scripture references in the Daily Office Lectionary of the _Book of Common Prayer, 2019_, Anglican Church in North America.

= 0.9 =

This version:

1. adds the reading plans "Heartlight Old and New Testament," "One Year Chronological," and "Through the Bible in a Year."

1. restructures and standardizes way copyright statements are stored and output, rewording them for completeness and clarity.

= 0.8 =

This version:

1. adds the reading plans "Every Day In the Word," "Literary Study Bible," and "Back to the Bible Chronological."

1. adds logic to prevent the calendar from being displayed more than once.

= 0.7 =

This version:

1. adds reading plans from the Daily Office Lectionary of the _Book of Common Prayer, 2019_, Anglican Church in North America.

1. adds ability to use readings from the Apocrypha, defaulting to the Apocrypha of the American Bible Society's King James Version, Ecumenical, if no books from the Apocrypha are available in the version used for the readings.

1. restructures Scriptures output.

1. returns key lengths to 32 characters for ABS and DBP APIs and 40 characters for the ESV API.

= 0.6.3 =

This version:

1. allows longer key lengths for all APIs.

= 0.6.2 =

This version:

1. fixes problems with passages not displaying correctly when multiple chapters from same book were included in the readings for a day.

= 0.6.1 =

This version:

1. fixes bug that prevented reading plans created with the Create Bible Reading Plans plugin from working with the ESV Bible Web Service API.

1. improves formatting of Psalms by modifing .esv-text span.end-line-group in brp-esv-scripture-styles.css.

= 0.6 =

This version:

1. adds the the ESV Bible Web Service API as a source of Scriptures, which includes audio for the Scriptures as well as the ability to format the text better than that from the DBP API.

1. retrieves list of versions from APIs only when the settings screen is used, at which time they are stored in the database. All other times the list is retrieved from the database.

= 0.5.2 =

This version:

1. fixes bugs in the retrieval and storage sequencing of available Scripture versions.

1. adds code to ensure API keys are of the correct length.

= 0.5.1 =

This version fixes a bug in the error reporting of getting Scriptures from remote servers.

= 0.5 =

This version:

1. obtains correct array of Bible versions from API.Bible.

1. provides option for displaying or not displaying plan name on page.

1. fixes several places where arrays or objects are expected, but not present.

1. uses recommended methods for enqueuing JavaScript libraries.

1. displays error message when API key is missing or incorrect.

1. displays error message when JavaScript is deactivated in browser.

1. makes changes to the description and instructions to clarify a number of points.

= 0.4.1 =

This version implements addition of omitted style sheets.

= 0.4 =

This version implements:

1.	An additional source of Scriptures has been added: API.Bible (American Bible Society).

1.	Rationalization of function names.

= 0.3 =

This version implements:

1.	Compatibility with the premium plugin "Create Bible Reading Plans" (https://sllwi.re/p/1Il).

1.	Addition of another version of the Bible.

1.  Storing of reading plan arrays in the database, rather than a directory.

1.	Use of core WordPress CSS for Datepicker.

= 0.2 =

This version incorporates changes that require each user of the plugin to register at the Digital Bible Platform and get their own Access Key.

= 0.1 =

Initial release.

== Changelog ==

= 2.1.3 =

This version:

1. Bug fix: Display Table of Contents is registered in Pages settings.

1. Bug fix: Link to Create Bible Reading plans is corrected to https://sllwi.re/p/1Il.

= 2.1.2 =

This version:

1. First day of week for the calendar is set to that of the first day of the week set in the WordPress options for English calendars (the script for the calendar for other languages set this).

1. Screenshot of Create Bible Readings Plans plugin settings screen to text linking to that plugin is added.

1. Bug fix: Table of Contents is corrected so that it now displays in the language of the page.

1. Bug fix: Heading for first Scripture is corrected so that readings to be only for the language of the page, instead of a combination of that language and English.

1. Bug fixes: Scripture references for Book of Common Prayer, 2019, Anglican Church in North America -- Evening Prayer for 7 and 22 October are corrected.

1. Bug fix: Table of Contents text is aligned center, as originally intended.

1. Bug fix: Repetition of Apocryphal books is corrected.

= 2.1.1 =

The .pot languages file is updated.

= 2.1 =

This version:

1. A floating table of contents is added.

1. A typo on line 1460 of bible-reading-plans-class.inc.php of version 2.0.2 is corrected.

1. Some code is restructured for easier maintenance.

= 2.0.2 =

This version:

1. The call to the method which checks on whether or not there are any new reading plans is moved from the method which initializes the administrative settings to the __construct() method in order to make sure all new or corrected plans are available even if the administrative settings are not accessed after an upgrade.

1. Scripture references in a number of places where the references were from a specific verse to the end of the chapter for the Book of Common Prayer, 2019, Anglican Church in North America for the ESV API are corrected.

= 2.0.1 =

This version:

1. Problem with the AJAX call that was causing a conflict with some other plugins is corrected.

1. Scripture reference for Book of Common Prayer, 2019, Anglican Church in North America -- Evening Prayer for 23 June is corrected.

= 2.0 =

This version:

1. Access to over 1700 versions in more than 1500 languages via the Bible Brain (aka the Digital Bible Platform) API is added.

1. On-the-fly conversion of plans created by the Create Bible Reading Plans plugins to Version 4 of the Bible Brain (aka Digital Bible Platform) API is provided.

1. The URL for the ESV Scriptures source is corrected.

1. An error in CSS class brp-no-readings -- there was a colon where there should have been a semi-colon is corrected.

1. A statement to CSS class brp-no-readings -- "padding-left: 10.5em !important;" is added to class eb-container .p1,

1. Certain places that Scripture references were repeated are corrected.

= 1.1.3 =

1. The <pre> tags some themes place around the shortcode, causing the text to not wrap, are removed.
 
= 1.1.2 =

1. Yet another problem with rendering proper Scriptures when the reference is a book with only one chapter is corrected.

1. Problem with rendering Jeremiah 35:1-36:32 properly on 20 October for the "Every Day In the Word" plan is corrected.

= 1.1.1 =

1. An additional problem with rendering proper Scriptures when the reference is a book with only one chapter is corrected.

= 1.1 =

1. Version 4 of the Bible Brain (aka Digital Bible Platform) API is implemented (requiring a significant code re-write).

1. Problem with rendering proper Scriptures when the reference is a book with only one chapter is corrected.

1. More appropriate formatting for poetic books from the Bible Brain (aka Digital Bible Platform) API is provided.

= 1.0.8 =

1. Bug which was inhibiting plugin activation fixed.

1. Plugin URI added to help with potential conflicts with other plugins.

1. Changed Text Domain to bible-reading-plans (from bible_reading_plans).

= 1.0.7 =

1. Problem with rendering proper Scriptures when the reference spans more than one chapter (e.g, 2 Kings 8:1-9:13) is corrected.

1. Scripture reference for Book of Common Prayer, 2019, Anglican Church in North America -- Morning Prayer for 2 June is corrected.

= 1.0.6 =

1. Problem of Firefox not playing audio is corrected.

1. Scripture reference for Book of Common Prayer, 2019, Anglican Church in North America -- Morning Prayer for 17 May is corrected.

1. Further improvements to the spacing of headings and wrapping of text around calendar in Scriptures from esv.org are made.

1. Bug-fixes -- Scripture references which are just book and chapter (no verses specified) and undefined variable "$heading."

= 1.0.5 =

1. Conflict with the Elementor plugin is fixed.

1. A Scripture reference for Book of Common Prayer, 2019, Anglican Church in North America -- Morning Prayer for 5 May is corrected.

1. Wrapping of Psalm titles around calendar (when calendar in text option is selected) is improved for Scriptures from esv.org.

= 1.0.4 =

1. Issue with calendar not appearing on mobile phones or above Scriptures (when that option is selected) is fixed.

1. Wrapping of text around calendar (when calendar in text option is selected) is corrected for Scriptures from esv.org.

1. Scripture references for Every Day in the Word Psalms for 27 April is corrected.

= 1.0.3 =

1. Conflict with WordFence firewall blocks when Yoast SEO plugin is also active is fixed.

= 1.0.2 =

1. The corrected Every Day in the Word reading plan is actually uploaded.

= 1.0.1 =

1. Errors in the Every Day in the Word reading plan are corrected.

= 1.0 =

1. The reading plans "Chronicles and Prophets," "Gospel and Epistles," "Pentateuch and History of Israel," and "Psalms and Wisdom Literature" are added.

1. Text from esv.org is enhanced by including passage headings.

1. One of the Scripture references in the Daily Office Lectionary of the _Book of Common Prayer, 2019_, Anglican Church in North America is corrected.

= 0.9 =

1. The reading plans "Heartlight Old and New Testament," "One Year Chronological," and"Through the Bible in a Year" are added.

1. Copyright statements are restructured and the way they are stored and output is standardized, while rewording them for completeness and clarity.

= 0.8 =

1. The reading plans "Every Day In the Word," "Literary Study Bible," and "Back to the Bible Chronological" are added.

1. Logic to prevent the calendar from being displayed more than once is added.

= 0.7 =

1. Reading plans from the Daily Office Lectionary of the _Book of Common Prayer, 2019_, Anglican  by including passage headingsChurch in North America, are added.

1. Ability to use readings from the Apocrypha added, defaulting to the Apocrypha of the American Bible Society's King James Version, Ecumenical, if no books from the Apocrypha are available in the version used for the readings.

1. Scriptures output restructured.

1. Key lengths returned to 32 characters for ABS and DBP APIs and to 40 characters for the ESV API.

= 0.6.3 =

1. Key lengths increased for all APIs.

= 0.6.2 =

1. Fixed problems with passages not displaying correctly when multiple chapters from same book were included in the readings for a day.

= 0.6.1 =

1. Fixed bug that prevented reading plans created with the Create Bible Reading Plans plugin from working with the ESV Bible Web Service API.

1. Modified <code>.esv-text span.end-line-group</code> in brp-esv-scripture-styles.css to improve formatting of Psalms.

= 0.6

1. Adds the the ESV Bible Web Service API as a source of Scriptures, which includes audio for the Scriptures as well as the ability to format the text better than that from the DBP API.

1. Retrieves list of versions from APIs only when the settings screen is used, at which time they are stored in the database. All other times the list is retrieved from the database.

= 0.5.2 =

1. Fixes bugs in the retrieval and storage sequencing of available Scripture versions.

1. Code added to ensure API keys are of the correct length.

= 0.5.1 =

Fixes bug in error reporting of getting Scriptures from remote servers.

= 0.5 =

1. Correct array of Bible versions from API.Bible is obtained.

1. Option for displaying or not displaying plan name on page is provided.

1. Several places where arrays or objects are expected, but not present, are fixed.

1. Enqueues JavaScript libraries using recommended methods.

1. When API key is missing or incorrect an error message is displayed.

1. When JavaScript is deactivated in browser an error message is displayed.
 by including passage headings
1. Instructions are clarified.

= 0.4.1 =

Addition of omitted style sheets.

= 0.4 =

1.	API.Bible (American Bible Society) added as an additional source of Scriptures.

1.	Function naming rationalization.	

= 0.3 =

1.	Incorporates compatibility with the premium plugin "Create Bible Reading Plans" (https://sllwi.re/p/1Il).

1.	Addition of another version of the Bible. by including passage headings

1.	Incorporates storing of reading plan arrays in the database, rather than a directory.

1.	Incorporates use of core WordPress CSS for Datepicker.

= 0.2 =

Incorporates changes that require each user of the plugin to register at the Digital Bible Platform and get their own Access Key.

= 0.1 =

Initial release.
