<?php
namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model {
	protected $table = 'gebruikers';
	protected $primaryKey = 'id';
	
	protected $returnType = 'App\Entities\User';
	protected $useTimeStamps = false;

	protected $allowedFields = ['recovery', 'recovery_valid', 'email', 'wachtwoord', 'engels', 'nieuwsbrief', 'zichtbaar_email'];
}