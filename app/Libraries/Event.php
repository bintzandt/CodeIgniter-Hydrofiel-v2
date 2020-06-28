<?php

namespace App\Libraries;

use App\Entities\Event as EventEntity;

class Event {
	public function displayRegistration(EventEntity $event): string {
		if (!$event->needsRegistration) {
			return sprintf('<tr><td>%s</td></tr>', lang('Event.noRegistrationNeeded'));
		}

		if (empty($event->registrations)) {
			return sprintf('<tr><td>%s</td></tr>', lang('Event.noRegistrations'));
		}

		return view('event/partials/registrationList', ['registrations' => $event->registrations]);
	}

	/**
	 * Function to display the form content on the event details page.
	 */
	public function displayForm(EventEntity $event) {
		if ($event->currentUserIsRegistered()) {
			if ($event->cancellationDeadlinePassed()) {
				// User cannot cancel the registration.
				return warning(lang('Event.noCancel'));
			}
		
			return sprintf('<div class="form-group"><button type="submit" class="btn btn-primary form-control">%s</a></div>', lang('Event.cancel'));
		}
		
		if ($event->isFull()) {
			return warning(lang('Event.full'));
		}

		if ($event->registrationDeadlinePassed()) {
			return warning(lang('Event.registrationClosed'));
		}

		// Display a special form for the nszk.
		if ($event->kind === 'nszk'){
			echo view('event/partials/strokes', ['slagen' => json_decode($event->strokes)]);
		}

		// Display the registration form.
		return view('event/partials/registerForm', ['needsPayment' => $event->needsPayment]);
	}
}
