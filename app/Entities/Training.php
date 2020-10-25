<?php

namespace App\Entities;

use Error;
use CodeIgniter\I18n\Time;

class Training extends Event {
	
	/**
	 * Is the registration open for this event?
	 * - Start time of event should be before next saturday 9 am.
	 * - Start time of event should be after previous saturday 9 am.
	 */
	public function isRegistrationOpen(): bool {
		return $this->from < new Time('next saturday 9am') && $this->from >= Time::now();
	}

	/**
	 * Returns whether the current user is already registered for another training in the upcoming week.
	 * - Fetches all trainings in the upcoming week
	 * - Filters them by the currentUserIsRegistered function
	 * - Returns whether the registered_trainins array is larger than 0.
	 */
	public function isUserRegisteredForOtherTraining(){
		$trainings = model('App\Models\TrainingModel')->getUpcomingTrainings();
		$registered_trainings = array_filter($trainings, function( $training ) {
			return $training->currentUserIsRegistered();
		} );
		return sizeof($registered_trainings) > 0;
	}

	/**
	 * Extends the Event registration function with two additional checks:
	 * - Are the registrations still closed?
	 * - Is the user already registered for another training this week?
	 * 
	 * @throws Error Error If one of the scenario's above is true, we throw an Error.
	 */
	public function attemptRegistration(?string $remark = null, ?string $strokes = null): void {
		if (! $this->isRegistrationOpen()){
			throw new Error(lang('Training.registrationNotOpen'));
		}

		// Calculate the difference in time from now.
		$diff = $this->from->difference(Time::now());

		// One training per week does not apply if the training starts in less than 3 hours.
		if ($diff->hours > 3 && $this->isUserRegisteredForOtherTraining()){
			throw new Error(lang('Training.maximumNumber'));
		}

		parent::attemptRegistration($remark);
	}
}