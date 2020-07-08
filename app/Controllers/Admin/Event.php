<?php

namespace App\Controllers\Admin;

use \App\Controllers\BaseController;
use \App\Models\EventModel;
use \App\Entities\Event as EventEntity;
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
}
