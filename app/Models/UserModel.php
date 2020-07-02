<?php
namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model {
	protected $table = 'gebruikers';
	protected $primaryKey = 'id';
	
	protected $returnType = 'App\Entities\User';
	protected $useTimeStamps = false;

	protected $allowedFields = ['recovery', 'recovery_valid', 'email', 'wachtwoord', 'engels', 'nieuwsbrief', 'zichtbaar_email'];

	/**
	 * Get a list of upcoming birthdays.
	 */
	public function getUpcomingBirthdays(int $limit = 3){
		$db = db_connect();
		$query  = $db->query(
			"
			SELECT id,naam, DATE_FORMAT(geboortedatum, '%d-%m-%Y') as geboortedatum, DATE_FORMAT(geboortedatum, '%Y') as geboortejaar
			FROM gebruikers 
			WHERE DATE_FORMAT(geboortedatum, '%m%d') >= DATE_FORMAT(now(), '%m%d')
			ORDER BY DATE_FORMAT(geboortedatum, '%m%d') ASC
			LIMIT $limit
			"
		);
		return $query->getResult();
	}
}