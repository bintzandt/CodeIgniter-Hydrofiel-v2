<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class TrainingModel extends Model {

	protected $table = 'events';
	protected $primaryKey = 'eventId';

	protected $returnType = 'App\Entities\Training';
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

	public function getUpcomingTrainings() {
		return $this
			->where('from <', new Time('saturday 9am'))
			->where('from >=', new Time('previous saturday 9am'))
			->whereIn('kind', EventModel::TRAINING_TYPES)
			->orderBy('from', 'ASC')
			->find();
	}

	/**
	 * Returns a list of passed trainings so the board can check the attendance.
	 */
	public function getPassedTrainings() {
		return $this
			->where('from <', Time::now())
			->whereIn('kind', EventModel::TRAINING_TYPES)
			->orderBy('from', 'DESC')
			->find();
	}
}
