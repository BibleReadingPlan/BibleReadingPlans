<?php
	$this->audio_full_chap_note	= __('At present, only the full chapter of the audio is available for this passage in this version.', 'bible-reading-plans');
	$this->audio_none_note		= __('There is no audio available for this passage in this version.', 'bible-reading-plans');
	$this->brp_prefix		 	= 'brp_';
	$this->calendar_in_text	 	= true;
	$this->cbrp_prefix		 	= 'cbrp_';
	$this->date_format_js	 	= 'DD d MM yy';
	$this->date_format_php	 	= 'l j F Y';
	$this->dev_screen_width	 	= 999;
	$this->display_holy_days	= false;
	$this->display_mvble_feasts	= false;
	$this->display_plan_name 	= true;
	$this->display_toc			= false;
	$this->end_verse			= 999;
	$this->js_date_format	 	= 'DD d MM yy';
	$this->language				= 'ENG';
	$this->language_code 		= 'ENG'; // Legacy. Only used in versions prior to 2.0.
	$this->language_name		= 'English';
	$this->lng_code_iso			= 'eng';
	$this->lng_code_to_2_ltr_cd	= array('ENG' => 'en',);
	$this->loading_image		= '<img title="'.__('Please wait until screen completes loading.', 'bible-reading-plans').'" class="brp_loading_img" src="'.$this->plugin_url.'images/ajax-loading.gif" />';
	$this->loading				= '<div class="brp-loading">'.__('Please wait.', 'bible-reading-plans').'<br />'.$this->loading_image.'<br />'.__('It takes a little time to load and process all of the data required to present the daily Scriptures readings.', 'bible-reading-plans').'</div>';
	$this->php_date_format	 	= 'l j F Y';
	$this->powered_by		 	= __('Powered by the <a href="https://wordpress.org/extend/plugins/bible-reading-plans/" target="_blank" title="Bible Reading Plans">Bible Reading Plans</a> plugin for WordPress.', 'bible-reading-plans');
	$this->site_lang_default	= 'English';
	$this->site_language		= 'English';
	$this->scptr_src_prefix	 	= 'dbp_'; // default.
	$this->switch_cal_width  	= 480;
	$this->timeout_frontend		= 60000; // Sets timeout to one minute (which should be reduced by code improvements).
	$this->use_audio			= false;
	$this->use_calendar			= false;
?>
