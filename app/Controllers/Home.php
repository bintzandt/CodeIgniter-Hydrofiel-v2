<?php namespace App\Controllers;

use CodeIgniter\HTTP\RedirectResponse;

class Home extends BaseController
{
	/**
	 * Displays the home page.
	 */
	public function index()
	{
		$data = [
			'engels' => isEnglish(),
			'events' => [],
			'verjaardagen' => [],
			'posts' => [],
			'session' => $this->session,
		];
		return view('templates/home', $data );
	}

	/**
	 * Switch the language from the current session. Does not save anything to the user object.
	 * 
	 * @return RedirectResponse Redirects to the previous page.
	 */
	public function switchLanguage(): RedirectResponse {
		switchLanguage();
		return redirect()->back();
	}

	//--------------------------------------------------------------------

}
