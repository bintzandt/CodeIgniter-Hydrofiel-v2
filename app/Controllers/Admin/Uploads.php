<?php

namespace App\Controllers\Admin;

use \App\Controllers\BaseController;

/**
 * Class for handling file uploads.
 */
class Uploads extends BaseController {
	/**
	 * Sets up the helpers.
	 */
	public function __construct() {
		helper('form');
	}

	/**
	 * Displays a list of uploads.
	 */
	public function index() {
		return view('admin/uploads');
	}
}
