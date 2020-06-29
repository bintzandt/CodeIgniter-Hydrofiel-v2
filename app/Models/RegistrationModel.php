<?php

namespace App\Models;

use CodeIgniter\Model;

class RegistrationModel extends Model {
	protected $table = 'inschrijvingen';
	protected $primaryKey = 'event_id';

	protected $returnType = 'App\Entities\Registration';
	protected $useTimeStamps = true;
	protected $createdFields = 'datum';

	protected $allowedFields = ['event_id', 'member_id', 'opmerking', 'slagen'];

	public function isUserRegisteredForEvent(int $userId, int $eventId): bool {
		return sizeof($this->where('event_id', $eventId)->where('member_id', $userId)->find()) === 1;
	}

	public function registerUserForEvent(int $userId, int $eventId, ?string $remark = null, ?string $strokes): void {
		$this->insert([
			'event_id' => $eventId,
			'member_id' => $userId,
			'opmerking' => $remark,
			'slagen' => $strokes,
		]);
	}

	public function cancelUserForEvent(int $userId, int $eventId) {
		$this->where('event_id', $eventId)->where('member_id', $userId)->delete();
	}
}
