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

	protected $casts = [
		'needsPayment' => 'boolean',
		'needsRegistration' => 'boolean',
		'maximumRegistrations' => 'int',
	];

	protected $dates = ['from', 'until', 'registrationDeadline', 'cancellationDeadline'];

	/**
	 * Constructs the Event Entity.
	 * 
	 * Sets up the RegistrationModel.
	 */
	public function __construct(?array $data = null) {
		parent::__construct($data);
		$this->registrationModel = new RegistrationModel();
	}

	/**
	 * Gets the name of the event.
	 * 
	 * Automatically switches between the Dutch and English name.
	 */
	public function getName(): string {
		return isEnglish() ? $this->nameEN : $this->nameNL;
	}

	/**
	 * Gets the description of the event.
	 * 
	 * Automatically switches between the Dutch and English description.
	 */
	public function getDescription(): string {
		return isEnglish() ? $this->descriptionEN : $this->descriptionNL;
	}

	/**
	 * Setter for the start date.
	 * 
	 * Converts the input to a MySQL format.
	 */
	public function setFrom(string $from): void {
		$this->attributes['from'] = $this->formatToMySQLDate($from);
	}

	/**
	 * Setter for the end date.
	 * 
	 * Converts the input to a MySQL format.
	 */
	public function setUntil(string $until): void {
		$this->attributes['until'] = $this->formatToMySQLDate($until);
	}

	/**
	 * Setter for the registration deadline.
	 * 
	 * First checks whether the registration deadline is needed for this event.
	 * 
	 * Converts the input to a MySQL format.
	 */
	public function setRegistrationDeadline(string $registrationDeadline): void {
		if (!$this->needsRegistration) {
			return;
		}
		$this->attributes['registrationDeadline'] = $this->formatToMySQLDate($registrationDeadline);
	}

	/**
	 * Setter for the cancelation deadline.
	 * 
	 * First checks whether the cancelation deadline is needed for this event.
	 * 
	 * Converts the input to a MySQL format.
	 */
	public function setCancellationDeadline(string $cancelationDeadline): void {
		if (!$this->needsRegistration) {
			return;
		}
		$this->attributes['cancellationDeadline'] = $this->formatToMySQLDate($cancelationDeadline);
	}

	/**
	 * Setter for the strokes.
	 * 
	 * If this event is not an NSZK, set strokes to NULL.
	 * 
	 * Otherwise, filter out the empty strokes and json_encode the result.
	 */
	public function setStrokes(array $strokes): void {
		if ($this->kind !== 'nszk') {
			$this->attributes['strokes'] = null;
		} else {
			$strokes = array_filter($strokes, function ($stroke) {
				return $stroke !== "";
			});
			$this->attributes['strokes'] = json_encode($strokes);
		}
	}

	/**
	 * Returns whether the user in the session is registered for the event.
	 * 
	 * @return bool
	 */
	public function currentUserIsRegistered(): bool {
		return $this->registrationModel->isUserRegisteredForEvent(currentUserId(), $this->eventId);
	}

	/**
	 * Returns whether the cancelation deadline has passed for this event.
	 * 
	 * @return bool
	 */
	public function cancellationDeadlinePassed(): bool {
		return $this->cancellationDeadline->isBefore(Time::now());
	}

	/**
	 * Returns whether the registration deadline has passed for this event.
	 * 
	 * @return bool
	 */
	public function registrationDeadlinePassed(): bool {
		return $this->registrationDeadline->isBefore(Time::now());
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
		return $this->registrationModel->where('eventId', $this->eventId)->orderBy('registrationDate')->findAll();
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

		// Event without maximumRegistrations cannot be full.
		if ($this->maximumRegistrations === 0) {
			return false;
		}

		return $this->nrOfRegistrations === $this->maximumRegistrations;
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
		$this->registrationModel->registerUserForEvent(currentUserId(), $this->eventId, $remark, $strokes);
	}

	/**
	 * Attempts to cancel the registration of the current user.
	 * 
	 * @param int $userId An optional ID of a user.
	 * 
	 * @throws Error Error when the cancelation deadline has passed.
	 */
	public function attemptCancellation(?int $userId = null) {
		// Admins can cancel a registration after the deadline has passed.
		if ($this->cancellationDeadlinePassed() && !isAdmin()) {
			throw new Error(lang('Event.noCancel'));
		}

		// Remove registration details for nszk's.
		if ($this->kind === 'nszk') {
			$registrationDetailsModel = new RegistrationDetailsModel();
			$registrationDetailsModel->removeUserDetailsForEvent($userId ?? currentUserId(), $this->eventId);
		}

		// Remove the registration.
		$this->registrationModel->cancelUserForEvent($userId ?? currentUserId(), $this->eventId);
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
