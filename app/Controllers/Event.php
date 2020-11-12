<?php

namespace App\Controllers;

use App\Models\EventModel;
use App\Models\RegistrationDetailsModel;
use App\Models\TrainingModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use Error;

class Event extends BaseController
{
    /**
     * The eventModel.
     *
     * @var EventModel $events
     */
    protected EventModel $events;

    /**
     * @var TrainingModel The Model for trainings.
     */
    protected TrainingModel $trainings;

    public function __construct()
    {
        $this->events = new EventModel();
        $this->trainings = new TrainingModel();
        helper(['form', 'notification']);
    }

    public function index()
    {
        $upcomingEvents = $this->events->getUpcomingEvents();

        return view('event/overview', ['events' => $upcomingEvents]);
    }

    public function id(int $eventId): string
    {
        $event = $this->events->find($eventId);
        if (!$event) {
            throw new PageNotFoundException();
        }

        return view('event/id', ['event' => $event]);
    }

    public function displayTrainingOverview()
    {
        $upcomingTrainings = $this->trainings->getUpcomingTrainings();

        $waterpoloTrainings = array_filter(
            $upcomingTrainings,
            function ($training) {
                return $training->kind === 'waterpolo_training';
            }
        );
        $swimTrainings = array_filter(
            $upcomingTrainings,
            function ($training) {
                return $training->kind === 'swim_training';
            }
        );

        return view(
            'event/trainingOverview',
            ['swimTrainings' => $swimTrainings, 'waterpoloTrainings' => $waterpoloTrainings]
        );
    }

    public function handleFormSubmission(int $eventId)
    {
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

            $remark = $this->request->getPost('remark');

            // Handle NSZK registration.
            if ($event->kind === 'nszk') {
                return $this->handleNSZKSubmission($event, $remark);
            }

            // It's an Training, fetch the correct class.
            if (in_array($event->kind, EventModel::TRAINING_TYPES)) {
                $event = model('App\Models\TrainingModel')->find($eventId);
            }

            // Handle normal registration.
            $event->attemptRegistration($remark);
            return redirect()->back()->with('success', lang('Event.registrationSuccess'));
        } catch (Error $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * A separate function to handle the registration for a NSZK.
     *
     * This function differs from the normal registration function in the following aspects:
     * - It creates a list of stroke / time entries that are saved in the DB as well.
     * - At the end, it displays a form where additional details can be entered.
     */
    private function handleNSZKSubmission(\App\Entities\Event $event, ?string $remark)
    {
        // Get a list of all strokes and times that are available.
        $possibleStrokes = $this->request->getPost('slag');
        $possibleTimes = $this->request->getPost('tijd');

        // Create an empty array to store the data.
        $strokes = [];

        /**
         * Loop over all the possible strokes and see if there is a corresponding time.
         * If there is, add the stroke/time combination to the array that is saved to the DB.
         */
        for ($i = 0; $i < sizeof($possibleStrokes); $i++) {
            if ($possibleTimes[$i] !== "") {
                $strokes[$possibleStrokes[$i]] = $possibleTimes[$i];
            }
        }

        /**
         * Make sure the user actually entered a time for some stroke.
         *
         * We do not want to store an json_encoded empty array.
         */
        if (empty($strokes)) {
            $strokes = null;
        } else {
            $strokes = json_encode($strokes);
        }

        $event->attemptRegistration($remark, $strokes);
        return $this->displayDetailsForm($event->eventId);
    }

    /**
     * Display a form where additional details can be filled in.
     */
    public function displayDetailsForm(int $eventId)
    {
        $registrationDetailsModel = new RegistrationDetailsModel();
        $details = $registrationDetailsModel->getUserDetailsForEvent(currentUserId(), $eventId);
        $event = $this->events->find($eventId);
        return view(
            'event/detailsForm',
            [
                'event' => $event,
                'edit_mode' => !!$details,
                'details' => $details,
            ]
        );
    }

    public function handleDetailsForm(int $eventId)
    {
        $data = $this->request->getPost();
        $registrationDetailsModel = new RegistrationDetailsModel();

        $registrationDetailsModel->removeUserDetailsForEvent(currentUserId(), $eventId);
        $registrationDetailsModel->addUserDetailsForEvent(currentUserId(), $eventId, $data);
        return redirect()->to('/event/' . $eventId)->with('success', lang('Event.registrationSuccess'));
    }
}
