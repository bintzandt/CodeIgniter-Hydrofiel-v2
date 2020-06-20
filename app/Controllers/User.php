<?php
namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class User extends BaseController {
	/**
	 * Model for working with users.
	 */
	protected UserModel $users;

	public function __construct(){
		helper('user');
		$this->users = new UserModel();
	}

	/**
	 * Loads the profile page for a given user.
	 * 
	 * Retrieves the userId from the session if none is provided.
	 * 
	 * @return string The page.
	 */
	public function index( int $id = null ): string {
		if (! $id){
			$id = currentUserId();
		}

		$user = $this->users->find($id);

		if (!$user){
			throw new PageNotFoundException();
		}

		return view('user/profile', ['user' => $user]);
	}

	/**
	 * Loads the edit page for a given user.
	 * 
	 * @return string The edit profile page.
	 */
	public function edit( int $id ){
		helper('form');
		$user = $this->users->find($id);
		return view('user/edit', ['user' => $user]);
	}

	public function save( int $id ){
		$data = $this->request->getPost();
		
		$rules = [
			'email' => 'required|valid_email',
		];

		if (!$this->validate($rules)){
			return redirect()->back()->withInput();
		}

		$user = $this->users->find($id);

		if ( $data['wachtwoord1'] !== ''){
			
			$user->password = $data['wachtwoord1'];
		}
		// Unset password data.
		unset($data['wachtwoord1']);
		unset($data['wachtwoord2']);

		$user->fill($data);
		
		if ($user->hasChanged()){
			$this->users->save($user);
		}

		return redirect()->back()->with('success', lang('User.profileSaved'));
	}
}