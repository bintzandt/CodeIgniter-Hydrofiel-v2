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

	/**
	 * Constructs the Event Entity.
	 * 
	 * Sets up the RegistrationModel.
	 */
	public function __construct(?array $data = null): void {
		parent::__construct($data);
		$this->registrationModel = new RegistrationModel();
	}

	/**
	 * Gets the name of the event.
	 * 
	 * Automatically switches between the Dutch and English name.
	 */
	public function getName(): string {
		return isEnglish() ? $this->en_naam : $this->nl_naam;
	}

	/**
	 * Gets the description of the event.
	 * 
	 * Automatically switches between the Dutch and English description.
	 */
	public function getDescription(): string {
		return isEnglish() ? $this->en_omschrijving : $this->nl_omschrijving;
	}

	/**
	 * Setter for the start date.
	 * 
	 * Converts the input to a MySQL format.
	 */
	public function setVan(string $from): void {
		$this->attributes['van'] = $this->formatToMySQLDate($from);
	}

	/**
	 * Setter for the end date.
	 * 
	 * Converts the input to a MySQL format.
	 */
	public function setTot(string $until): void {
		$this->attributes['tot'] = $this->formatToMySQLDate($until);
	}

	/**
	 * Setter for the registration deadline.
	 * 
	 * First checks whether the registration deadline is needed for this event.
	 * 
	 * Converts the input to a MySQL format.
	 */
	public function setInschrijfdeadline(string $registrationDeadline): void {
		if (!$this->needsRegistration) {
			return;
		}
		$this->attributes['inschrijfdeadline'] = $this->formatToMySQLDate($registrationDeadline);
	}

	/**
	 * Setter for the cancelation deadline.
	 * 
	 * First checks whether the cancelation deadline is needed for this event.
	 * 
	 * Converts the input to a MySQL format.
	 */
	public function setAfmelddeadline(string $cancelationDeadline): void {
		if (!$this->needsRegistration) {
			return;
		}
		$this->attributes['afmelddeadline'] = $this->formatToMySQLDate($cancelationDeadline);
	}

	/**
	 * Setter for the strokes.
	 * 
	 * If this event is not an NSZK, set strokes to NULL.
	 * 
	 * Otherwise, filter out the empty strokes and json_encode the result.
	 */
	public function setSlagen(array $strokes): void {
		if ($this->kind !== 'nszk') {
			$this->attributes['slagen'] = null;
		} else {
			$strokes = array_filter($strokes, function ($stroke) {
				return $stroke !== "";
			});
			$this->attributes['slagen'] = json_encode($strokes);
		}
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
	public function getNrOfRegistrations(): int {
		return sizeof($this->registrations);
	}

	/**
	 * Getter for an array of registrations.
	 * 
	 * First checks whether the registrations are set on the current object before fetching them from the DB.
	 * 
	 * @return array The registrations.
	 */
	public function getRegistrations(): array {
		if (!isset($this->registrationArray)) {
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
	public function attemptCancellation() {
		if ($this->cancellationDeadlinePassed()) {
			throw new Error(lang('Event.noCancel'));
		}

		// Remove registration details for nszk's.
		if ($this->kind === 'nszk') {
			$registrationDetailsModel = new RegistrationDetailsModel();
			$registrationDetailsModel->removeUserDetailsForEvent(currentUserId(), $this->event_id);
		}

		// Remove the registration.
		$this->registrationModel->cancelUserForEvent(currentUserId(), $this->event_id);
	}

	/**
	 * Formats a DateString to something MySQL can understand.
	 * 
	 * @return string A string MySQL can handle.
	 */
	private function formatToMySQLDate(string $dateString): string {
		return date_format(date_create($dateString), 'Y-m-d H:i:s');
	}
}
