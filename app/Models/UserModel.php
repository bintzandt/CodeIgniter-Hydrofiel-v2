<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model {
	protected $table = 'users';
	protected $primaryKey = 'userId';

	protected $returnType = 'App\Entities\User';
	protected $useTimeStamps = false;

	protected $allowedFields = [
		'userId',
		'name',
		'recoveryToken',
		'birthday',
		'recoveryTokenValidUntil',
		'email',
		'passwordHash',
		'preferEnglish',
		'receiveNewsletter',
		'membership',
		'showEmail',
	];

	/**
	 * Get a list of upcoming birthdays.
	 */
	public function getUpcomingBirthdays(int $limit = 3) {
		$db = db_connect();
		$query  = $db->query(
			"
			SELECT userId,name, DATE_FORMAT(birthday, '%d-%m-%Y') as geboortedatum, DATE_FORMAT(birthdat, '%Y') as geboortejaar
			FROM users 
			WHERE DATE_FORMAT(birthday, '%m%d') >= DATE_FORMAT(now(), '%m%d')
			ORDER BY DATE_FORMAT(birthday, '%m%d') ASC
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
				$this->whereIn('membership', ['waterpolo_competitie', 'waterpolo_recreatief']);
				break;
			case 'nieuwsbrief':
				// This group consists of everyone that wants to receive the newsletter.
				$this->where('receiveNewsletter', true);
			case 'bestuur':
				// This group consists of the board, i.e. everyone with rank 2.
				$this->where('role', 2);
				break;
			case 'iedereen':
				// This group consists of everyone, i.e. no constraints.
				break;
			case 'leden':
				// This group consits of all the members, i.e. no friends of Hydrofiel
				$this->where('membership !=', 'vriend');
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
				$this->where('membership', $group);
				break;
		}
		return $this
			->select('email')
			->where('preferEnglish', $english)
			->findAll();
	}
}
