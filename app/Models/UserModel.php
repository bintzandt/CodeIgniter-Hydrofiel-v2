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

	/**
	 * Gets a list of recipients belonging to a certain group.
	 */
	public function getGroupRecipients( string $group, bool $english): array {
		switch($group){
			// This group consists of both recreative and competition players.
			case 'waterpolo': $this->whereIn('lidmaatschap', ['waterpolo_competitie', 'waterpolo_recreatief']); break;
			// This group consists of everyone that wants to receive the newsletter.
			case 'nieuwsbrief': $this->where('nieuwsbrief', true);
			// This group consists of the board, i.e. everyone with rank 2.
			case 'bestuur': $this->where('rank', 2); break;
			// This group consists of everyone, i.e. no constraints.
			case 'iedereen': break;
			// This is an empty group, meant for individual selections.
			case 'select': return [];
			/**
			 * By default, filter on the provided group. This default applies to the following groups:
			 * - trainers
			 * - waterpolo_recreatief
			 * - waterpolo_competitief
			 * - zwemmers
			 */
			default: $this->where('lidmaatschap', $group); break;
		}
		return $this
			->select('email')
			->where('engels', $english)
			->findAll();
	}
}