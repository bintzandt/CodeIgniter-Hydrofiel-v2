<?php

namespace App\Entities;

use CodeIgniter\Entity;
use CodeIgniter\I18n\Time;

class User extends Entity {
	protected $casts = [
		'showEmail' => 'boolean',
		'receiveNewsletter' => 'boolean',
		'preferEnglish' => 'boolean',
		'role' => 'int',
		'userId' => 'int',
	];

	protected $dates = ['recoveryTokenValidUntil', 'birthday'];

	/**
	 * Set the ID of a user.
	 */
	public function setUserId(string $id): User {
		$this->attributes['userId'] = intval(preg_replace('/[^0-9]/', '', $id));
		return $this;
	}

	/**
	 * Function to update the password from an user.
	 * 
	 * @return $this
	 */
	public function setPasswordHash(string $plaintextPassword): User {
		$this->attributes['passwordHash'] = password_hash($plaintextPassword, PASSWORD_DEFAULT);

		// Unset recovery options
		$this->attributes['recoveryToken'] = null;
		$this->attributes['recoveryTokenValidUntil'] = null;

		return $this;
	}

	/**
	 * Returns a localised string of the membership field.
	 * 
	 * @return string Localised membership string.
	 */
	public function getMembership(): string {
		switch ($this->attributes['membership']) {
			case 'waterpolo_competitie':
				return lang('User.waterpoloCompetition');
			case 'waterpolo_recreatief':
				return lang('User.waterpoloRecreation');
			case 'trainer':
				return lang('User.trainer');
			case 'vriend':
				return lang('User.friend');
			case 'zwemmer':
			default:
				return lang('User.swimmer');
		}
	}

	/**
	 * Convert a readable membership string to a database representation.
	 */
	public function setMembership(string $membership): User {
		$this->attributes['membership'] = $this->convertMembership($membership);

		return $this;
	}

	/**
	 * Convert a datestring to a Time object.
	 */
	public function setBirthday(string $birthday): User {
		$this->attributes['birthday'] = new Time($birthday);
		return $this;
	}

	/**
	 * Get the locale for the current user.
	 * 
	 * Currently only checks the preferEnglish attribute.
	 */
	public function getLocale(): string {
		return $this->attributes['preferEnglish'] ? 'en' : 'nl';
	}

	/**
	 * Function to create a name using a firstname, middlename and lastname.
	 */
	public static function createName(string $firstName, string $middleName, string $lastName): string {
		if ($middleName === '') {
			return implode(' ', [$firstName, $lastName]);
		}

		return implode(' ', [$firstName, $middleName, $lastName]);
	}

	/**
	 * Returns whether this user is an admin.
	 * 
	 * @return bool true if this user is admin, false otherwise.
	 */
	public function isAdmin(): bool {
		return $this->role <= 2;
	}

	/**
	 * Attempt to sign in this user using the provided plainTextPassword.
	 * 
	 * @return bool true if sign was successful, false otherwise.
	 */
	public function attemptLogin($plaintextPassword): bool {
		if (!password_verify($plaintextPassword, $this->passwordHash)) {
			return false;
		}

		// Check if the password needs to be updated.
		if (password_needs_rehash($this->passwordHash, PASSWORD_DEFAULT)) {
			$this->setPasswordHash($plaintextPassword);
		}

		// Unset recovery options
		$this->attributes['recoveryToken'] = null;
		$this->attributes['recoveryTokenValidUntil'] = null;

		// Save the updated user.
		if ($this->hasChanged()) {
			$userModel = new \App\Models\UserModel();
			$userModel->save($this);
		}

		// Login succesful.
		return true;
	}

	/**
	 * Generate a hash for resetting the password.
	 * 
	 * @param bool $isNewUser Hashes for new users are valid for a week, as opposed to one hour for normal resets.
	 * 
	 * @return $this
	 */
	public function generateResetHash(bool $isNewUser = false) {
		$this->recoveryToken = bin2hex(random_bytes(16));
		$this->recoveryTokenValidUntil = date('Y-m-d H:i:s', time() + ($isNewUser ? 604800 : 3600));

		return $this;
	}

	/**
	 * Converts a membership from Conscribo to a membership in our database.
	 */
	private function convertMembership(string $membership): string {
		switch ($membership) {
			case 'Waterpolo - wedstrijd':
				return 'waterpolo_competitie';
			case 'Waterpolo - recreatief':
				return 'waterpolo_recreatief';
			case 'Trainers':
				return 'trainer';
			case 'Overige':
				return 'overig';
			case 'Friend':
				return 'vriend';
			default:
				return 'zwemmer';
		}
	}
}
