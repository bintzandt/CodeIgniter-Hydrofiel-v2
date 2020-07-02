<?php

namespace App\Controllers\Admin;

use \App\Controllers\BaseController;
use App\Models\UserModel;

class Mail extends BaseController {
	public function __construct() {
		helper(['form']);
	}

	public function index() {
		$users = new UserModel();
		return view('admin/mail/index', ['leden' => $users->findAll()]);
	}

	public function handleEmailFormSubmission(){
		var_dump($this->request->getPost()); exit;
	}
}
