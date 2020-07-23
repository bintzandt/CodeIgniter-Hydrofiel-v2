<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model {
	protected $table = 'gebruikers';
	protected $primaryKey = 'id';

	protected $returnType = 'App\Entities\User';
	protected $useTimeStamps = false;

	protected $allowedFields = [
		'id',
		'naam',
		'recovery',
		'geboortedatum',
		'recovery_valid',
		'email',
		'wachtwoord',
		'engels',
		'nieuwsbrief',
		'lidmaatschap',
		'zichtbaar_email',
	];

	/**
	 * Get a list of upcoming birthdays.
	 */
	public function getUpcomingBirthdays(int $limit = 3) {
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
	public function getGroupRecipients(string $group, bool $english): array {
		switch ($group) {
			case 'waterpolo':
				// This group consists of both recreative and competition players.
				$this->whereIn('lidmaatschap', ['waterpolo_competitie', 'waterpolo_recreatief']);
				break;
			case 'nieuwsbrief':
				// This group consists of everyone that wants to receive the newsletter.
				$this->where('nieuwsbrief', true);
			case 'bestuur':
				// This group consists of the board, i.e. everyone with rank 2.
				$this->where('rank', 2);
				break;
			case 'iedereen':
				// This group consists of everyone, i.e. no constraints.
				break;
			case 'leden':
				// This group consits of all the members, i.e. no friends of Hydrofiel
				$this->where('lidmaatschap !=', 'vriend');
				break;
			case 'select':
				// This is an empty group, meant for individual selections.
				return [];
				/**
				 * By default, filter on the provided group. This default applies to the following groups:
				 * - trainers
				 * - waterpolo_recreatief
				 * - waterpolo_competitief
				 * - zwemmers
				 */
			default:
				$this->where('lidmaatschap', $group);
				break;
		}
		return $this
			->select('email')
			->where('engels', $english)
			->findAll();
	}
}
