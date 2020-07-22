<?php

namespace App\Controllers\Admin;

use \App\Controllers\BaseController;
use \App\Entities\Page;
use App\Models\PageModel;

/**
 * Class for handling the editing, creation and deletion of pages.
 */
class Pages extends BaseController {
	protected PageModel $pages;

	/**
	 * Sets up the PageModel.
	 */
	public function __construct() {
		helper('form');
		$this->pages = new PageModel();
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
	public function addOrEdit(int $pageId = null) {
	}

	/**
	 * Deletes a page.
	 */
	public function delete(int $pageId) {
	}

	/**
	 * Moves a page up in the hierarcy.
	 */
	public function up(int $pageId) {
	}

	/**
	 * Moves a page down in the hierarcy.
	 */
	public function down(int $pageId) {
	}
}
