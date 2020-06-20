<?php
use Config\Services;
/**
 * The goal of this file is to allow developers a location
 * where they can overwrite core procedural functions and
 * replace them with their own. This file is loaded during
 * the bootstrap process and is called during the frameworks
 * execution.
 *
 * This can be looked at as a `master helper` file that is
 * loaded early on, and may also contain additional functions
 * that you'd like to use throughout your entire application
 *
 * @link: https://codeigniter4.github.io/CodeIgniter4/
 */

if (! function_exists('lang'))
{
	/**
	 * We overwrite the default lang function because we want to be able to overwrite the language in the session.
	 *
	 * @param string|[] $line
	 * @param array     $args
	 * @param string    $locale
	 *
	 * @return string
	 */
	function lang(string $line, array $args = [])
	{
		if (!function_exists('isEnglish')){
			helper('language');
		}
		
		$locale = 'nl';
		if (isEnglish()){
			$locale = 'en';
		}
		return Services::language($locale)
			->getLine($line, $args);
	}
}
