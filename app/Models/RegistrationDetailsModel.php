<?php

namespace App\Models;

use CodeIgniter\Model;

class RegistrationDetailsModel extends Model {
	protected $table = 'registrationDetails';
	/**
	 * This is the same ID as eventId.
	 * 
	 * This ID is not enough to get valid results so don't use it on its own.
	 */
	protected $primaryKey = 'eventId';

	protected $returnType = 'object';
	protected $useTimeStamps = false;

	protected $allowedFields = [
		'eventId',
		'userId',
		'attendPredrink',
		'attendDinner',
		'attendParty',
		'requiresSleepAccommodation',
		'attendOutboundJourney',
		'attendHomeboundJourney',
		'requiresContactByBoard',
	];

	public function hasUserEnteredDetails(int $userId, int $eventId): bool {
		return sizeof($this->where('eventId', $eventId)->where('userId', $userId)->find()) === 1;
	}

	public function addUserDetailsForEvent(int $userId, int $eventId, $details): void {
		$this->insert(
			array_merge(
				[
					'eventId' => $eventId,
					'userId' => $userId,
				],
				$details,
			)
		);
	}

	public function getUserDetailsForEvent(int $userId, int $eventId){
		return $this->where('eventId', $eventId)->where('userId', $userId)->first();
	}

	public function removeUserDetailsForEvent(int $userId, int $eventId) {
		$this->where('eventId', $eventId)->where('userId', $userId)->delete();
	}
}
