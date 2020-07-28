<?php

namespace App\Libraries;

use App\Models\UserModel;
use App\Models\EventModel;
use App\Entities\User;

class Mail {
	protected UserModel $users;
	protected EventModel $events;

	public function __construct() {
		$this->users = new UserModel();
		$this->events = new EventModel();
	}

	/**
	 * Adds email-addresses from a comma seperated string.
	 */
	public function getCustomRecipients(string $emails, array &$recipients): void {
		// Regex to filter out all the spaces
		$emails = preg_replace('/\s+/', '', $emails);
		// Create an array of the string using ',' as delimiter
		$test_mail = explode(',', $emails);
		// Run over the array to check whether each mail adress is valid
		if (!empty($test_mail)) {
			foreach ($test_mail as $address) {
				if (filter_var($address, FILTER_VALIDATE_EMAIL)) {
					$recipients[] = $address;
				}
			}
		}
	}

	/**
	 * Gets recipients based on the group to which they belong.
	 */
	public function getGroupRecipients(string $group, bool $english, array &$recipients): void {
		$recipients = array_merge($recipients, array_map([$this, 'getEmailFromUser'], $this->users->getGroupRecipients($group, $english)));
	}

	/**
	 * Gets recipients based on an array of selected userIds.
	 */
	public function getSelectedRecipients(array $userIds, bool $english, array &$recipients): void {
		$result = $this->users->whereIn('userId', $userIds)->where('preferEnglish', $english)->findAll();
		$recipients = array_merge($recipients, array_map([$this, 'getEmailFromUser'], $result));
	}

	/**
	 * Gets an array with a name and an emailaddress that can be used to set the from address.
	 */
	public function getFrom(string $from): array {
		switch ($from) {
			case 'penningmeester':
				return [
					'name' => 'Penningmeester N.S.Z.&W.V. Hydrofiel',
					'email' => 'penningmeester@hydrofiel.nl',
				];
			case 'zwemmen':
				return [
					'name' => 'Zwemcommissaris N.S.Z.&W.V. Hydrofiel',
					'email' => 'zwemcommissaris@hydrofiel.nl',
				];
			case 'waterpolo':
				return [
					'name' => 'Waterpolocommissaris N.S.Z.&W.V. Hydrofiel',
					'email' => 'waterpolocommissaris@hydrofiel.nl',
				];
			case 'algemeen':
				return [
					'name' => 'Commissaris Algemeen N.S.Z.&W.V. Hydrofiel',
					'email' => 'commissarisalgemeen@hydrofiel.nl',
				];
			case 'secretaris':
				return [
					'name' => 'Secretaris N.S.Z.&W.V. Hydrofiel',
					'email' => 'secretaris@hydrofiel.nl',
				];
			case 'voorzitter':
				return [
					'name' => 'Voorzitter N.S.Z.&W.V. Hydrofiel',
					'email' => 'voorzitter@hydrofiel.nl',
				];
			case 'activiteiten':
				return [
					'name' => 'Activiteitencommissie N.S.Z.&W.V. Hydrofiel',
					'email' => 'activiteitencommissie@hydrofiel.nl',
				];
			case 'webmaster':
				return [
					'name' => 'Webmaster N.S.Z.&W.V. Hydrofiel',
					'email' => 'webmaster@hydrofiel.nl',
				];
			case 'bestuur':
			default:
				return [
					'name' => 'Bestuur N.S.Z.&W.V. Hydrofiel',
					'email' => 'bestuur@hydrofiel.nl',
				];
		}
	}

	/**
	 * Gets the HTML message content based on the chosen layout and content.
	 * 
	 * @var string $layout The layout which will be used to send the email.
	 * @var array $data An array that contains the content and if this mail is English.
	 */
	public function getMessageContent(string $layout, array $data): string {
		switch ($layout) {
			case 'standaard':
				return view('email/default', $data);
			case 'nieuwsbrief':
				$data['events'] = $this->events->getUpcomingEvents(3);
				return view('email/nieuwsbrief', $data);
			default:
				return $data['content'];
		}
	}

	/**
	 * Function to extract the email from an User entity.
	 * 
	 * @return string The email of the user.
	 */
	private function getEmailFromUser(User $user): string {
		return $user->email;
	}
}
