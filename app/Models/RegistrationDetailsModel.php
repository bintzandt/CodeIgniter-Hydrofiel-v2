<?php

namespace App\Models;

use CodeIgniter\Model;

class RegistrationDetailsModel extends Model {
	protected $table = 'nszk_inschrijfsysteem';
	/**
	 * This is the same ID as event_id.
	 * 
	 * This ID is not enough to get valid results so don't use it on its own.
	 */
	protected $primaryKey = 'nszk_id';

	protected $returnType = 'array';
	protected $useTimeStamps = false;

	protected $allowedFields = [
		'nszk_id',
		'member_id',
		'preborrel',
		'avondeten',
		'feest',
		'slapen',
		'groep_heen',
		'groep_terug',
		'speciaal',
	];

	public function hasUserEnteredDetails(int $userId, int $eventId): bool {
		return sizeof($this->where('nszk_id', $eventId)->where('member_id', $userId)->find()) === 1;
	}

	public function addUserDetailsForEvent(int $userId, int $eventId, $details): void {
		$this->insert(
			array_merge(
				[
					'nszk_id' => $eventId,
					'member_id' => $userId,
				],
				$details,
			)
		);
	}

	public function removeUserDetailsForEvent(int $userId, int $eventId) {
		$this->where('nszk_id', $eventId)->where('member_id', $userId)->delete();
	}
}
