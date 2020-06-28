<?php

namespace App\Controllers;

use App\Models\EventModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\RedirectResponse;
use Error;

class Event extends BaseController {
	/**
	 * The eventModel.
	 * 
	 * @var EventModel $events
	 */
	protected EventModel $events;

	public function __construct() {
		$this->events = new EventModel();
		helper(['form', 'notification']);
	}

	public function id(int $eventId): string {
		$event = $this->events->find($eventId);
		if (!$event) {
			throw new PageNotFoundException();
		}

		return view('event/id', ['event' => $event]);
	}

	public function handleFormSubmission(int $eventId) {
		/**
		 * @var \App\Entities\Event $event
		 */
		$event = $this->events->find($eventId);

		try {
			// Check if the current user is registered.
			if ($event->currentUserIsRegistered()) {
				// Try to cancel the registration.
				$event->attemptCancellation();
				return redirect()->back()->with('success', lang('Event.cancelSuccess'));
			}

			if ($event->kind === 'nszk') {
				// Handle NSZK registration.
				return;
			}

			// Handle normal registration.
			$remark = $this->request->getPost('opmerking');
			$event->attemptRegistration($remark);
			return redirect()->back()->with('success', lang('Event.registrationSuccess'));
		} catch (Error $e) {
			return redirect()->back()->withInput()->with('error', $e->message);
		}
	}
}
