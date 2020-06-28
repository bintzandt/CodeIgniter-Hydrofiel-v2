<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\RedirectResponse;

class User extends BaseController {
	/**
	 * Model for working with users.
	 */
	protected UserModel $users;

	public function __construct() {
		helper(['user', 'form', 'email']);
		$this->users = new UserModel();
	}

	/**
	 * Loads the profile page for a given user.
	 * 
	 * Retrieves the userId from the session if none is provided.
	 * 
	 * @return string The page.
	 */
	public function index(int $id = null): string {
		if (!$id) {
			$id = currentUserId();
		}

		$user = $this->users->find($id);

		if (!$user) {
			throw new PageNotFoundException();
		}

		return view('user/profile', ['user' => $user]);
	}

	/**
	 * Loads the edit page for a given user.
	 *
	 * @Filter: IsAdminOrRequestedUser Make sure that the save action is allowed.
	 *
	 * @return string The edit profile page.
	 */
	public function edit(int $id): string {
		$user = $this->users->find($id);
		return view('user/edit', ['user' => $user]);
	}

	/**
	 * Saves a user.
	 * 
	 * @Filter: IsAdminOrRequestedUser Make sure that the save action is allowed.
	 * 
	 * @return RedirectResponse Redirect back to the edit page. 
	 */
	public function save(int $id): RedirectResponse {
		$data = $this->request->getPost();

		$rules = [
			'email' => 'required|valid_email',
			'wachtwoord2' => 'matches[wachtwoord1]',
		];

		if (!$this->validate($rules)) {
			return redirect()->back()->withInput();
		}

		$user = $this->users->find($id);

		if ($data['wachtwoord1'] !== '') {
			$user->password = $data['wachtwoord1'];
		}

		$user->fill($data);

		// Send an email to the secretary if the email changed.
		if ($user->hasChanged('email')) {
			sendUserUpdateEmail($user);
		}

		if ($user->hasChanged()) {
			$this->users->save($user);
		}

		return redirect()->back()->with('success', lang('User.profileSaved'));
	}
}
