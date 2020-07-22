<?php

namespace App\Controllers\Admin;

use \App\Controllers\BaseController;
use \App\Entities\Page;
use App\Models\PageModel;
use App\Models\MenuModel;

/**
 * Class for handling the editing, creation and deletion of pages.
 */
class Pages extends BaseController {
	protected PageModel $pages;
	protected MenuModel $menu;

	/**
	 * Sets up the PageModel.
	 */
	public function __construct() {
		helper('form');
		$this->pages = new PageModel();
		$this->menu = new MenuModel();
	}

	/**
	 * Displays a list of pages.
	 */
	public function index() {
		return view('admin/page/index', ['pages' => $this->pages->getPagesHierarchical()]);
	}

	/**
	 * Function for adding or editing a page.
	 */
	public function addOrEdit(int $pageId = -1) {
		$page = $this->pages->find($pageId);
		$data = [
			'edit_mode' => !!$page,
			'page' => $page,
			'hoofdmenu' => $this->menu->getMenu(),
		];
		return view('admin/page/addOrEdit', $data);
	}

	/**
	 * Persist the changes to the DB.
	 */
	public function save(){
		$pageData = $this->request->getPost();
		
		if ( $pageData['mainMenuItem'] === '1'){
			$pageData['submenu'] = 'A';
		} else {
			$pageData['submenu'] = $pageData['na'];
		}

		$page = new Page($pageData);
		if ($this->pages->save($page)){
			return redirect()->to('/admin')->with('success', 'Pagina is opgeslagen');
		}

		return redirect()->to('/admin')->with('error', 'Er ging iets mis bij het opslaan van de pagina');
	}

	/**
	 * Deletes a page.
	 */
	public function delete(int $pageId) {
		if ($this->pages->delete($pageId)){
			return redirect()->back()->with('success', 'Pagina is verwijderd');
		}

		return redirect()->back()->with('error', 'Niet gelukt om de pagina te verwijderen');
	}
}
