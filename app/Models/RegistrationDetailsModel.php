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

	/**
	 * Returns whether the provided user has entered registration details for a certain event.
	 */
	public function hasUserEnteredDetails(int $userId, int $eventId): bool {
		return sizeof($this->where('eventId', $eventId)->where('userId', $userId)->find()) === 1;
	}

	/**
	 * Save registration details to the DB for an event and an user.
	 */
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

	/**
	 * Get the registration details for a user and an event.
	 */
	public function getUserDetailsForEvent(int $userId, int $eventId) {
		return $this->where('eventId', $eventId)->where('userId', $userId)->first();
	}

	/**
	 * Remove the registration details for a user and an event.
	 */
	public function removeUserDetailsForEvent(int $userId, int $eventId) {
		$this->where('eventId', $eventId)->where('userId', $userId)->delete();
	}
}
