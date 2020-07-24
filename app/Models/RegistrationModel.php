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

	public function isUserRegisteredForEvent(int $userId, int $eventId): bool {
		return sizeof($this->where('eventId', $eventId)->where('userId', $userId)->find()) === 1;
	}

	public function registerUserForEvent(int $userId, int $eventId, ?string $remark = null, ?string $strokes): void {
		$this->insert([
			'eventId' => $eventId,
			'userId' => $userId,
			'remark' => $remark,
			'strokes' => $strokes,
		]);
	}

	public function cancelUserForEvent(int $userId, int $eventId): void {
		$this->where('eventId', $eventId)->where('userId', $userId)->delete();
	}

	public function getUserRegistrationForEvent(int $userId, int $eventId): Registration {
		return $this->where('eventId', $eventId)->where('userId', $userId)->first();
	}
}
