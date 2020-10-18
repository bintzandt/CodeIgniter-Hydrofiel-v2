<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class EventModel extends Model {
	const TRAINING_TYPES = ['training', 'swim_training', 'waterpolo_training'];

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
			->whereNotIn('kind', self::TRAINING_TYPES)
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
			->whereNotIn('kind', self::TRAINING_TYPES)
			->limit($limit)
			->orderBy('from', 'DESC')
			->find();
	}
}
