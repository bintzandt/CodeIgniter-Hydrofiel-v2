<?php

namespace App\Controllers\Admin;

use \App\Controllers\BaseController;
use \App\Models\EventModel;
use \App\Entities\Event as EventEntity;
use App\Models\RegistrationDetailsModel;
use App\Models\RegistrationModel;
use CodeIgniter\HTTP\RedirectResponse;

class Event extends BaseController {
	protected EventModel $events;

	public function __construct() {
		helper(['form']);
		$this->events = new EventModel();
	}

	/**
	 * Shows an overview of all events.
	 */
	public function index(): string {
		$data = [
			'upcomingEvents' => $this->events->getUpcomingEvents(),
			'passedEvents' => $this->events->getPassedEvents(),
		];
		return view('admin/event/index', $data);
	}

	/**
	 * Displays a form that can be used to create or update an event.
	 */
	public function addOrEdit(?int $eventId = -1): string {
		$event = $this->events->find($eventId);
		$data = [
			'edit_mode' => !!$event,
			'event' => $event,
		];
		return view('admin/event/addOrEdit', $data);
	}

	/**
	 * Either updates or creates an Event in the DB.
	 * 
	 * Redirects back to the event overview page.
	 */
	public function saveEvent(): RedirectResponse {
		$eventData = $this->request->getPost();
		
		$rules = [
			'event_id' => 'if_exist|integer',
			'nl_naam' => 'required|string',
			'nl_omschrijving' => 'required|string',
			'en_naam' => 'required|string',
			'en_omschrijving' => 'required|string',
			'kind' => 'required|in_list[nszk,algemeen,toernooi]',
			'from' => 'required|valid_date[d-m-Y H:i]',
			'until' => 'required|valid_date[d-m-Y H:i]',
			'link' => 'if_exist|string',
			'location' => 'if_exist|string',
			'needsRegistration' => 'required|in_list[0,1]',
			'inschrijfdeadline' => 'if_exist|valid_date[d-m-Y H:i]',
			'afmelddeadline' => 'if_exist|valid_date[d-m-Y H:i]',
			'needsPayment' => 'if_exist|in_list[0,1]',
			'maximumRegistrations' => 'if_exist|integer',
		];
		
		if (!$this->validate($rules)) {
			return redirect()->back()->withInput();
		}

		$event = new EventEntity($eventData);
		if ($this->events->save($event)) {
			return redirect()->to('/admin/event')->with('success', 'Het evenement is opgeslagen');
		}
		return redirect()->to('/admin/event')->with('error', 'Er ging iets fout bij het opslaan van het evenement');
	}

	/**
	 * Deletes an event.
	 * 
	 * Redirects back to the previous place after deleting.
	 * 
	 * @param int $eventId The ID of the event.
	 */
	public function delete(int $eventId): RedirectResponse {
		if ($this->events->delete($eventId)) {
			return redirect()->back()->with('success', 'Het evenement is verwijderd');
		}
		return redirect()->back()->with('error', 'Er is iets fout gegaan');
	}

	/**
	 * Display an overview of all the registrations for an event.
	 */
	public function registrations(int $eventId): string {
		$event = $this->events->find($eventId);
		return view('admin/event/registrations', ['registrations' => $event->registrations]);
	}

	/**
	 * Removes the registration for a user.
	 * 
	 * @param int $eventId The ID of the event.
	 * @param int $userId The ID of the user.
	 * 
	 * @return RedirectResponse Redirects back to the previous page.
	 */
	public function cancelRegistration(int $eventId, int $userId): RedirectResponse {
		/**
		 * @var EventEntity $event
		 */
		$event = $this->events->find($eventId);
		$event->attemptCancellation($userId);
		return redirect()->back()->with('success', 'Registration is deleted');
	}

	/**
	 * Display the details for a certain registration
	 */
	public function registrationDetails(int $eventId, int $userId) {
		$registrationDetails = new RegistrationDetailsModel();
		$registrations = new RegistrationModel();

		$event = $this->events->find($eventId);
		$registration = $registrations->getUserRegistrationForEvent($userId, $eventId);

		$data = [
			'event_id' => $event->event_id,
			'details' => $registrationDetails->getUserDetailsForEvent($userId, $eventId),
			'nszk' => $event->kind === 'nszk',
			'inschrijving' => $registration,
			'slagen' => json_decode($registration->slagen ?? '[]'),
		];

		return view('admin/event/registrationDetails', $data);
	}
}
