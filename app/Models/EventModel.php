<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class EventModel extends Model {
	protected $table = 'events';
	protected $primaryKey = 'eventId';

	protected $returnType = 'App\Entities\Event';
	protected $useTimeStamps = false;

	protected $allowedFields = [
		'nameNL',
		'nameEN',
		'needsPayment',
		'location',
		'link',
		'descriptionNL',
		'descriptionEN',
		'from',
		'until',
		'needsRegistration',
		'registrationDeadline',
		'cancellationDeadline',
		'maximumRegistrations',
		'kind',
		'strokes',
	];

	/**
	 * Returns a list of upcoming events.
	 * 
	 * @param int $limit An optional parameter that defines how many events we want.
	 */
	public function getUpcomingEvents(?int $limit = null): array {
		return $this
			->where('from >=', Time::now())
			->where('kind !=', 'training')
			->limit($limit)
			->orderBy('from', 'ASC')
			->find();
	}

	/**
	 * Returns a list of passed events.
	 * 
	 * @param int $limit An optional parameter that defines how many events we want.
	 */
	public function getPassedEvents(?int $limit = null) {
		return $this
			->where('from <', Time::now())
			->where('kind !=', 'training')
			->limit($limit)
			->orderBy('from', 'DESC')
			->find();
	}

	public function getUpcomingTrainings() {
		return $this
			->where('from <', new Time('saturday + 1 weeks'))
			->where('kind', 'training')
			->orderBy('from', 'ASC')
			->find();
	}

	/**
	 * Returns a list of passed trainings so the board can check the attendance.
	 */
	public function getPassedTrainings() {
		return $this
			->where('from <', Time::now())
			->where('kind', 'training')
			->orderBy('from', 'DESC')
			->find();
	}
}
