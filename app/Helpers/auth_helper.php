<?php
use Config\Services;
use App\Models\UserModel;
use App\Entities\User;

if (! function_exists('isLoggedIn')){
	/**
	 * Checks whether an user is signed in.
	 * 
	 * @return bool true if someone has signed in, false otherwise.
	 */
	function isLoggedIn(): bool {
		$session = Services::session();
		return !! $session->loggedIn;
	}
}

if (! function_exists('currentUserId')){
	/**
	 * Retrieves the current userId from the session.
	 * 
	 * @return int|null The signed-in userId or null.
	 */
	function currentUserId(): ?int {
		if (!isLoggedIn()){
			return null;
		}

		$session = Services::session();
		return $session->get('userId');
	}
}

if (! function_exists('currentUser')){
	/**
	 * Retrieves the current user from the session.
	 * 
	 * @return User|null The signed-in user or null.
	 */
	function currentUser(): ?User {
		if (!isLoggedIn()){
			return null;
		}

		$session = Services::session();
		$userModel = new UserModel();
		return $userModel->find($session->get('userId'));
	}
}

if (! function_exists('isAdmin')){
	/**
	 * Checks if the current user is an admin.
	 * 
	 * @return bool true if the current user is admin, false otherwise.
	 */
	function isAdmin(): bool {
		return currentUser()->isAdmin();
	}
}

