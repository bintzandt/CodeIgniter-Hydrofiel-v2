<?php
namespace App\Entities;

use App\Models\UserModel;
use App\Entities\User;
use CodeIgniter\Entity;

class Registration extends Entity {
	protected UserModel $users;
	protected ?User $userData = null;

	protected $dates = ['registrationDate'];

	public function __construct()
	{
		$this->users = new UserModel();
	}

	public function getUser(){
		if (! $this->userData){
			$this->userData = $this->users->find($this->userId);
		}
		return $this->userData;
	}

	/**
	 * Get the name of the user who registered.
	 */
	public function getName(): string {
		return $this->user->name ?? '';
	}
}