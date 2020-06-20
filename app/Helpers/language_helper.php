<?php
use Config\Services;

if (! function_exists('isEnglish')){
	/**
	 * Function that returns whether the session is set to English.
	 * 
	 * @return bool true if session is English, false if session is Dutch.
	 */
	function isEnglish(): bool {
		$session = Services::session();
		return (bool) $session->get('english');
	}
}

if (! function_exists('switchLanguage')){
	/**
	 * Function to switch the language in the current session.
	 * 
	 * Can only be used to differentiate between Dutch and English.
	 */
	function switchLanguage(): void {
		$session = Services::session();
		$session->set('english', !isEnglish());
	}
}