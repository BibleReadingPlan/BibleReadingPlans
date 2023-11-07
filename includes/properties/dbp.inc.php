<?php
	$this->dbp_default_bible_id	= array('ENG' => array('ENGNAS' => __('New American Standard Bible', 'bible-reading-plans'),),); // Overrides dynamic value.
	/* Not used.
	$this->dbp_exclude_media	= array(__('Dramatized Audio', 'bible-reading-plans')				=> 'audio_drama',
										__('Audio', 'bible-reading-plans')							=> 'audio',
										__('Video', 'bible-reading-plans')							=> 'video_stream',
										__('Audio HLS stream', 'bible-reading-plans')				=> 'audio_stream',
										__('Dramatized Audio HLS Stream', 'bible-reading-plans')	=> 'audio_drama_stream',
										__('USX Text Files', 'bible-reading-plans')					=> 'text_usx',
										); */
	$this->dbp_key_length_max	= 36;
	$this->dbp_key_length_min	= 36;
	$this->dbp_language_id	 	= 'ENG';
	$this->dbp_language_iso	 	= 'eng';
	$this->dbp_lang_codes_excpt	= array('DEU' => 'GER', 'FRA' => 'FRN', 'TUR' => 'TRK',);
	$this->dbp_media_types		= array('audio_drama'			=> __('Dramatized Audio', 'bible-reading-plans'),
										'audio'					=> __('Audio', 'bible-reading-plans'),
										'video_stream'			=> __('Video', 'bible-reading-plans'),
										'audio_stream'			=> __('Audio HLS stream', 'bible-reading-plans'),
										'audio_drama_stream'	=> __('Dramatized Audio HLS Stream', 'bible-reading-plans'),
										'text_format'			=> __('Formatted Text', 'bible-reading-plans'),
										'text_plain'			=> __('Plain Text', 'bible-reading-plans'),
										'text_usx'				=> __('USX Text Files', 'bible-reading-plans'),
										);
	$this->dbp_query_string		= 'https://4.dbt.io/api/';
	$this->dbp_query_base	 	= 'v=4';
	$this->dbp_sctr_src_url	 	= '<a href="https://biblebrain.com/" target="_blank">Bible Brain (aka Digital Bible Platform) API</a>';
	$this->dbp_vers_default	 	= array('ENG'  => array(
														'NAS' => __('New American Standard Bible', 'bible-reading-plans'),
														),
										);
?>
