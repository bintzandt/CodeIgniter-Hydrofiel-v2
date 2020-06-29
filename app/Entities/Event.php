<?php

namespace App\Entities;

use App\Models\RegistrationDetailsModel;
use App\Models\RegistrationModel;
use CodeIgniter\Entity;
use CodeIgniter\I18n\Time;
use Error;

class Event extends Entity {
	protected RegistrationModel $registrationModel;
	protected array $registrationArray;

	// Map non-english names to English for consistency across the codebase.
	protected $datamap = [
		'needsPayment' => 'betalen',
		'location' => 'locatie',
		'from' => 'van',
		'until' => 'tot',
		'maximumRegistrations' => 'maximum',
		'kind' => 'soort',
		'needsRegistration' => 'inschrijfsysteem',
		'strokes' => 'slagen',
	];

	protected $casts = [
		'needsPayment' => 'boolean',
		'needsRegistration' => 'boolean',
		'maximum' => 'int',
	];

	protected $dates = ['van', 'tot', 'inschrijfdeadline', 'afmelddeadline'];

	public function __construct() {
		$this->registrationModel = new RegistrationModel();
	}

	public function getName() {
		return isEnglish() ? $this->en_naam : $this->nl_naam;
	}

	public function getDescription() {
		return isEnglish() ? $this->en_omschrijving : $this->nl_omschrijving;
	}

	/**
	 * Returns whether the user in the session is registered for the event.
	 * 
	 * @return bool
	 */
	public function currentUserIsRegistered(): bool {
		return $this->registrationModel->isUserRegisteredForEvent(currentUserId(), $this->event_id);
	}

	/**
	 * Returns whether the cancelation deadline has passed for this event.
	 * 
	 * @return bool
	 */
	public function cancellationDeadlinePassed(): bool {
		return $this->afmelddeadline->isBefore(Time::now());
	}

	/**
	 * Returns whether the registration deadline has passed for this event.
	 * 
	 * @return bool
	 */
	public function registrationDeadlinePassed(): bool {
		return $this->inschrijfdeadline->isBefore(Time::now());
	}

	/**
	 * Query the Database for all the registrations for the current event.
	 */
	public function getNrOfRegistrations() {
		return sizeof($this->registrations);
	}

	public function getRegistrations(){
		if (!isset($this->registrationArray)){
			$this->registrationArray = $this->registrationModel->where('event_id', $this->event_id)->findAll();
		}

		return $this->registrationArray;
	}

	/**
	 * Returns whether the event is full.
	 * 
	 * @return bool
	 */
	public function isFull(): bool {
		// Events without registration can never be full.
		if (!$this->needsRegistration) {
			return false;
		}

		// Event without maximum cannot be full.
		if ($this->maximum === 0) {
			return false;
		}

		return $this->nrOfRegistrations === $this->maximum;
	}

	/**
	 * Attempts to register the current user.
	 * 
	 * @throws Error Error when the registration did not succeed.
	 */
	public function attemptRegistration(?string $remark = null, ?string $strokes = null): void {
		if ($this->registrationDeadlinePassed()) {
			throw new Error(lang('Event.registrationClosed'));
		}

		if ($this->isFull()) {
			throw new Error(lang('Event.full'));
		}

		// Create new registration.
		$this->registrationModel->registerUserForEvent(currentUserId(), $this->event_id, $remark, $strokes);
	}

	/**
	 * Attempts to cancel the registration of the current user.
	 * 
	 * @throws Error Error when the cancelation deadline has passed.
	 */
	public function attemptCancellation(){
		if ($this->cancellationDeadlinePassed()){
			throw new Error(lang('Event.noCancel'));
		}
		
		// Remove registration details for nszk's.
		if ($this->kind === 'nszk'){
			$registrationDetailsModel = new RegistrationDetailsModel();
			$registrationDetailsModel->removeUserDetailsForEvent(currentUserId(), $this->event_id);
		}

		// Remove the registration.
		$this->registrationModel->cancelUserForEvent(currentUserId(), $this->event_id);
	}
}
