<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Entities\User;
use App\Models\EventModel;
use App\Models\UserModel;
use CodeIgniter\I18n\Time;

/**
 * Class for importing users.
 */
class Users extends BaseController {
	protected UserModel $users;
	protected EventModel $events;

	const ID = 0;
	const FIRST_NAME = 1;
	const MIDDLE_NAME = 2;
	const LAST_NAME = 3;
	const BIRTHDAY = 8;
	const EMAIL = 11;
	const IS_ENGLISH = 12;
	const MEMBERSHIP = 14;

	/**
	 * Sets up the UserModel.
	 */
	public function __construct() {
		helper(['form', 'email']);
		$this->users = new UserModel();
		$this->events = new EventModel();
	}

	/**
	 * Displays four lists of users: swimmers, waterpoloers, trainers and friends of Hydrofiel.
	 */
	public function index() {
		$data = [
			'swimmers' => $this->users->where('membership', 'zwemmer')->orderBy('name')->findAll(),
			'waterpoloers' => $this->users->where('membership', 'waterpolo_competitie')->orWhere('membership', 'waterpolo_recreatief')->orderBy('name')->findAll(),
			'trainers' => $this->users->where('membership', 'trainer')->orderBy('name')->findAll(),
			'friends' => $this->users->where('membership', 'vriend')->orderBy('name')->findAll(),
		];
		return view('admin/user/index', $data);
	}

	/**
	 * Displays a form where a CSV containing users can be uploaded.
	 */
	public function import() {
		return view('admin/user/import');
	}

	/**
	 * Handles the import form submission.
	 */
	public function handleImport() {
		// Get the uploaded file and create a file handle.
		$uploadedFile = $this->request->getFile('users');
		$fileHandle = fopen($uploadedFile->getTempName(), 'r');

		// Create empty arrays to keep track of users.
		$ids = [];
		$newUsers = [];

		// Loop over all the rows in the file.
		while (($row = fgetcsv($fileHandle, 0, ';')) !== false) {
			// Clean data
			$row = $this->cleanData($row);

			// Get the ID.
			$id = $row[self::ID];

			// Add the ID to the array of IDs.
			array_push($ids, $id);

			$user = new User([
				'userId' => $id,
				'name' => User::createName($row[self::FIRST_NAME], $row[self::MIDDLE_NAME], $row[self::LAST_NAME]),
				'email' => $row[self::EMAIL],
				'birthday' => $row[self::BIRTHDAY],
				'preferEnglish' => $row[self::IS_ENGLISH],
				'membership' => $row[self::MEMBERSHIP],
			]);
			$this->users->find($id) ? $this->users->save($user) : array_push($newUsers, $user);
		}

		// Close the file.
		fclose($fileHandle);

		// Create new users.
		$this->createNewUsers($newUsers);

		// Remove old users.
		$this->users->where('membership !=', 'friend')->whereNotIn('userId', $ids)->delete();

		return redirect()->to('/admin/users')->with('success', 'De leden zijn bijgewerkt');
	}

	/**
	 * Friends of Hydrofiel can be removed using this function.
	 */
	public function delete(int $id) {
		$user = $this->users->find($id);

		if (!$user) {
			return redirect()->back()->with('error', 'Gebruiker bestaat niet');
		}

		if ($user->membership !== 'vriend') {
			return redirect()->back()->with('error', 'Gebruiker dient verwijdert te worden via conscribo');
		}

		if ($this->users->delete($id)) {
			return redirect()->back()->with('success', 'Gebruiker is verwijderd');
		}

		return redirect()->back()->with('error', 'Gebruiker is niet verwijderd');
	}

	/**
	 * Displays a form for adding a new friend of Hydrofiel.
	 */
	public function addFriend() {
		return view('admin/user/addFriend');
	}

	/**
	 * Handles the addFriend form submission.
	 * 
	 * Does the following things:
	 * - Validate the input (see $rules)
	 * - Sets the membership to 'Friend'
	 * - Saves the user to the DB
	 * - Sends a welcome email
	 */
	public function handleAddFriend() {
		if (!$this->validate('addFriend')) {
			return redirect()->back()->withInput();
		}

		$data = $this->request->getPost();

		// Set the membership to friend.
		$data['membership'] = 'Friend';

		// Create the new user and send a welcome email.
		$this->createNewUsers([new User($data)]);

		return redirect()->to('/admin/users')->with('success', 'Vriend is toegevoegd');
	}

	/**
	 * Creates new users using an array of UserEntities.
	 * 
	 * Does the following things:
	 * - Creates a new recovery token for the user
	 * - Persist the user to the database
	 * - Sends an email to the provided emailadress notifying the user of their new account
	 */
	private function createNewUsers(array $newUsers) {
		$events = $this->events->getUpcomingEvents(3);
		/**
		 * @var User $user
		 */
		foreach ($newUsers as &$user) {
			// Create a new recovery token for the user
			$user->generateResetHash(true);

			// Persist the user to the DB
			$this->users->insert($user);

			// Notify the user
			sendWelcomeEmail($user, $events);
		}
	}

	/**
	 * Removes all additional ' from the data array.
	 *
	 * @param string[] $data An array of strings that will be cleaned.
	 *
	 * @return string[] An array with cleaned data.
	 */
	private function cleanData(array $data): array {
		foreach ($data as $key => $value) {
			$val          = str_replace('\'', '', $value);
			$data[$key] = $val;
		}
		return $data;
	}
}
