<?php

namespace App\Controllers\Admin;

use \App\Controllers\BaseController;
use \App\Models\EventModel;
use \App\Models\TrainingModel;
use \App\Entities\Event;
use App\Models\RegistrationDetailsModel;
use App\Models\RegistrationModel;
use CodeIgniter\HTTP\RedirectResponse;

class Events extends BaseController {
	protected EventModel $events;

	public function __construct() {
		helper(['form']);
		$this->events = new EventModel();
		$this->trainings = new TrainingModel();
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
	 * Duplicate an existing event.
	 */
	public function duplicate(int $eventId): string {
		$event = $this->events->find($eventId);
		unset($event->eventId);
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

		if (!$this->validate('saveEvent')) {
			return redirect()->back()->withInput();
		}

		$event = new Event($eventData);
		if ($this->events->save($event)) {
			return redirect()->to('/admin/events')->with('success', 'Het evenement is opgeslagen');
		}
		return redirect()->to('/admin/events')->with('error', 'Er ging iets fout bij het opslaan van het evenement');
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
		// Make it possible to display different registration overviews based on the event type.
		switch ($event->kind){
			case 'social': return view('admin/event/registrations/social', [ 'registrations' => $event->registrations ] );
			default: return view('admin/event/registrations/default', ['registrations' => $event->registrations]);
		}
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
		 * @var Event $event
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
			'eventId' => $event->eventId,
			'details' => $registrationDetails->getUserDetailsForEvent($userId, $eventId),
			'nszk' => $event->kind === 'nszk',
			'inschrijving' => $registration,
			'strokes' => json_decode($registration->strokes ?? '[]'),
		];

		return view('admin/event/registrations/registrationDetails', $data);
	}

	/**
	 * Display an overview of all past trainings.
	 */
	public function training() {
		$pastTrainings = $this->trainings->getPassedTrainings();

		$waterpoloTrainings = array_filter( $pastTrainings, function ( $training ){
			return $training->kind === 'waterpolo_training';
		} );

		$swimTrainings = array_filter( $pastTrainings, function ( $training ){
			return $training->kind === 'swim_training';
		} );
		return view('admin/event/trainingOverview', ['waterpoloTrainings' => $waterpoloTrainings, 'swimTrainings' => $swimTrainings]);
	}
}
