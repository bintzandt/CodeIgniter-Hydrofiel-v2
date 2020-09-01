<?php

namespace App\Controllers\Admin;

use \App\Controllers\BaseController;
use App\Models\UserModel;
use App\Libraries\Mail as MailLibrary;

class Mail extends BaseController {
	protected MailLibrary $mailHelper;

	public function __construct() {
		helper(['form', 'email']);
		$this->mailHelper = new MailLibrary();
	}

	/**
	 * Displays a form where the board can send an email.
	 */
	public function index() {
		$users = new UserModel();
		return view('admin/mail', ['leden' => $users->findAll()]);
	}

	/**
	 * Handles the submission of the form.
	 * Sends an email to the chosen groups.
	 */
	public function handleEmailFormSubmission() {
		// Get data and prepare generic email settings.
		$data = $this->request->getPost();
		$from = $this->mailHelper->getFrom($data['van']);

		// Prepare Dutch email.
		$dutchAttachments = $this->request->getFileMultiple('attachments_nl');
		$dutchRecipients = $this->getArrayOfRecipients(false);
		$dutchSubject = $data['onderwerp'];
		$dutchMessage = $this->mailHelper->getMessageContent(
			$data['layout'],
			[
				'content' => $data['content'],
				'engels' => false,
			]
		);

		// Prepare English email.
		$englishAttachments = $this->request->getFileMultiple('attachments_en');
		$englishRecipients = $this->getArrayOfRecipients(true);
		$englishSubject = $data['en_onderwerp'];
		$englishMessage = $this->mailHelper->getMessageContent(
			$data['layout'],
			[
				'content' => $data['en_content'],
				'engels' => true
			]
		);

		if (
			sendEmail($from, 'no-reply@hydrofiel.nl', $dutchRecipients, $dutchSubject, $dutchMessage, $dutchAttachments) &&
			sendEmail($from, 'no-reply@hydrofiel.nl', $englishRecipients, $englishSubject, $englishMessage, $englishAttachments)
		) {
			return redirect()->back()->with('success', 'Mail is verstuurd');
		}

		return redirect()->back()->with('error', 'Er ging iets fout');
	}

	/**
	 * Returns an array of recipients based on the data posted in the form.
	 * 
	 * @param bool $english
	 * 
	 * @return string[] An array of emails.
	 */
	private function getArrayOfRecipients(bool $english): array {
		$data = $this->request->getPost();
		$recipients = [];

		// We assume that custom recipients are Dutch.
		if (!$english) {
			$this->mailHelper->getCustomRecipients($data['email'],  $recipients);
		}

		$this->mailHelper->getGroupRecipients($data['aan'], $english, $recipients);

		// Check if recipients were selected separately.
		if (isset($data['los'])) {
			$this->mailHelper->getSelectedRecipients($data['los'], $english, $recipients);
		}

		// Only return unqiue values.
		return array_unique($recipients);
	}
}
