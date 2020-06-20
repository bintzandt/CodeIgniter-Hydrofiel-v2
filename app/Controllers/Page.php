<?php
namespace App\Controllers;

use App\Models\PageModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\RedirectResponse;


class Page extends BaseController {
	/**
	 * The pageModel.
	 * 
	 * @var PageModel $pages
	 */
	protected PageModel $pages;

	public function __construct()
	{
		$this->pages = new PageModel();
	}

	/**
	 * Display the requested page.
	 * 
	 * If no ID is provided, we redirect back to the home page.
	 * 
	 * @return string|RedirectResponse The HTML response or a redirect.
	 */
	public function index( int $id = null ) {
		if (! $id || $id === 1){
			return redirect()->route('home');
		}

		$page = $this->pages->find($id);

		if (! $page){
			throw new PageNotFoundException();
		}

		if ($page->requiresLogIn && ! isLoggedIn()){
			return redirect()->route('login');
		}

		if ($page->naam === 'Wedstrijden'){
			return view('templates/matches');
		}

		return view('templates/page', ['text' => $page->text]);
	}
}