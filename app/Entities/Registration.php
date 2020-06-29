<?php
namespace App\Entities;

use App\Models\UserModel;
use CodeIgniter\Entity;

class Registration extends Entity {
	protected UserModel $users;

	protected $datamap = [
		'remark' => 'opmerking',
	];

	public function __construct()
	{
		$this->users = new UserModel();
	}

	/**
	 * Get the name of the user who registered.
	 */
	public function getName(){
		return $this->users->find($this->member_id)->name;
	}
}