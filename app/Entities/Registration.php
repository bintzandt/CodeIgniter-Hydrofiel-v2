<?php
namespace App\Entities;

use App\Models\UserModel;
use App\Entities\User;
use CodeIgniter\Entity;

class Registration extends Entity {
	protected UserModel $users;
	protected ?User $userData = null;

	protected $datamap = [
		'remark' => 'opmerking',
	];

	protected $dates = ['datum'];

	public function __construct()
	{
		$this->users = new UserModel();
	}

	public function getUser(){
		if (! $this->userData){
			$this->userData = $this->users->find($this->member_id);
		}
		return $this->userData;
	}

	/**
	 * Get the name of the user who registered.
	 */
	public function getName(): string {
		return $this->user->name;
	}
}