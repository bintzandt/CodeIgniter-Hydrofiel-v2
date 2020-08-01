<?php

namespace App\Controllers\Admin;

use CodeIgniter\Controller;

class Migrate extends Controller {

	public function index() {
		$migrate = \Config\Services::migrations();

		try {
			$migrate->latest();
			return redirect()->to('/')->with('success', 'Migrations were successful');
		} catch (\Throwable $e) {
			d($e);
		}
	}
}
