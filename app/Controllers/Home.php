<?php

namespace App\Controllers;

use App\Models\EventModel;
use App\Models\PostModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\RedirectResponse;

class Home extends BaseController {
	/**
	 * Displays the home page.
	 */
	public function index() {
		// Required model for providing all details shown on the homepage.
		$events = new EventModel();
		$users = new UserModel();
		$posts = new PostModel();

		$data = [
			'upcomingEvents' => $events->getUpcomingEvents(5),
			'upcomingBirthdays' => $users->getUpcomingBirthdays(5),
			'recentPosts' => $posts->orderBy('post_timestamp', 'DESC')->findAll(5),
		];
		return view('templates/home', $data);
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
