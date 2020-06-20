<?php

namespace App\Entities;

use CodeIgniter\Entity;
use Config\Services;

class User extends Entity
{
	// Map non-english names to English for consistency across the codebase.
	protected $datamap = [
		'name' => 'naam',
		'password' => 'wachtwoord',
		'birthday' => 'geboortedatum',
		'membership' => 'lidmaatschap',
		'preferEnglish' => 'engels',
		'visibleEmail' => 'zichtbaar_email',
		'receiveNewsletter' => 'nieuwsbrief',
	];

	protected $casts = [
		'visibleEmail' => 'boolean',
		'receiveNewsletter' => 'boolean',
		'preferEnglish' => 'boolean',
	];

	protected $dates = ['birthday', 'recovery_valid'];

	/**
	 * Function to update the password from an user.
	 * 
	 * @return $this
	 */
	public function setWachtwoord( string $plaintextPassword): User {
		$this->attributes['wachtwoord'] = password_hash($plaintextPassword, PASSWORD_DEFAULT);
		
		// Unset recovery options
		$this->attributes['recovery'] = null;
		$this->attributes['recovery_valid'] = null;
		
		return $this;
	}

	/**
	 * Returns a localised string of the membership field.
	 * 
	 * @return string Localised membership string.
	 */
	public function getLidmaatschap(): string {
		switch ($this->attributes['lidmaatschap']) {
			case 'waterpolo_competition': return lang('User.waterpoloCompetition');
			case 'waterpolo_recreatief': return lang('User.waterpoloRecreation');
			case 'trainer': return lang('User.traininer');
			case 'zwemmer':
			default: return lang('User.swimmer');
		}
	}

	public function getEngels(): string {
		return $this->attributes['engels'] ? 'checked' : '';
	}

	public function getNieuwsbrief(): string {
		return $this->attributes['nieuwsbrief'] ? 'checked' : '';
	}
	
	public function getZichtbaarEmail(): string {
		return $this->attributes['zichtbaar_email'] ? 'checked' : '';
	}

	/**
	 * Returns whether this user is an admin.
	 * 
	 * @return bool true if this user is admin, false otherwise.
	 */
	public function isAdmin(): bool {
		return $this->rank <= 2;
	}

	/**
	 * Attempt to sign in this user using the provided plainTextPassword.
	 * 
	 * @return bool true if sign was successful, false otherwise.
	 */
	public function attemptLogin($plaintextPassword): bool {
		if (!password_verify($plaintextPassword, $this->password)){
			return false;
		}

		// Check if the password needs to be updated.
		if (password_needs_rehash($this->password, PASSWORD_DEFAULT)){
			$this->setWachtwoord($plaintextPassword);
		}

		// Save details to the session.
		$session = Services::session();
		$session->set('english', $this->preferEnglish);
		$session->set('loggedIn', true);
		$session->set('userId', $this->id);
		
		// Unset recovery options
		$this->attributes['recovery'] = null;
		$this->attributes['recovery_valid'] = null;

		// Save the updated user.
		if ( $this->hasChanged() ){
			$userModel = new \App\Models\UserModel();
			$userModel->save($this);
		}
		
		// Login succesful.
		return true;
	}

	/**
	 * Generate a hash for resetting the password.
	 * 
	 * @return $this
	 */
	public function generateResetHash(){
		$this->recovery = bin2hex(random_bytes(16));
		$this->recovery_valid = date('Y-m-d H:i:s', time() + 3600);

		return $this;
	}
}
