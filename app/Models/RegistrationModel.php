<?php

namespace App\Models;

use App\Entities\Registration;
use CodeIgniter\Model;

class RegistrationModel extends Model {
	protected $table = 'registrations';
	protected $primaryKey = 'eventId';

	protected $returnType = 'App\Entities\Registration';
	protected $useTimeStamps = true;
	protected $createdFields = 'registrationDate';

	protected $allowedFields = ['eventId', 'userId', 'remark', 'strokes'];

	/**
	 * Returns true if the provided user is registered for the event, false othterwise.
	 */
	public function isUserRegisteredForEvent(int $userId, int $eventId): bool {
		return sizeof($this->where('eventId', $eventId)->where('userId', $userId)->find()) === 1;
	}

	/**
	 * Registers a user for an event.
	 */
	public function registerUserForEvent(int $userId, int $eventId, ?string $remark = null, ?string $strokes): void {
		$this->insert([
			'eventId' => $eventId,
			'userId' => $userId,
			'remark' => $remark,
			'strokes' => $strokes,
		]);
	}

	/**
	 * Cancels a user's registration for an event.
	 */
	public function cancelUserForEvent(int $userId, int $eventId): void {
		$this->where('eventId', $eventId)->where('userId', $userId)->delete();
	}

	/**
	 * Gets the registration for a user and an event.
	 */
	public function getUserRegistrationForEvent(int $userId, int $eventId): Registration {
		return $this->where('eventId', $eventId)->where('userId', $userId)->first();
	}
}
