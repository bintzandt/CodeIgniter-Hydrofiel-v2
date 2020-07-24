<?php

use App\Entities\User;
use Config\Services;

if (!function_exists('sendResetEmail')) {
	/**
	 * Send a reset password email.
	 * 
	 * @return bool Indicates whether the email was send succesfully.
	 */
	function sendResetPasswordEmail(User $user): bool {
		$from = [
			'name' => lang('Email.passwordResetSender'),
			'email' => 'no-reply@hydrofiel.nl',
		];

		return sendEmail(
			$from,
			$user->email,
			[],
			lang('Email.passwordResetSubject', [], $user),
			view(lang('Email.passwordResetPath', [], $user), [
				'recovery' => $user->recoveryToken,
				'valid' => $user->recoveryTokenValidUntil,
			]),
		);
	}
}

if (!function_exists('sendWelcomeEmail')) {
	/**
	 * Send a welcome email for a new user.
	 * 
	 * @return bool Indicates whether the email was send succesfully.
	 */
	function sendWelcomeEmail(User $user, array $events): bool {
		$email = Services::email();
		$email->clear(true);

		return $email
			->setFrom('bestuur@hydrofiel.nl', 'Bestuur N.S.Z.&W.V. Hydrofiel')
			->setTo($user->email)
			->setSubject(lang('Email.welcomeSubject', [], $user))
			->setMessage(view(lang('Email.welcomeView', [], $user), ['user' => $user, 'events' => $events]))
			->setMailType('html')
			->attach( APPPATH . lang('Email.welcomeAttachment', [], $user))
			->send();
	}
}

if (!function_exists('sendUserUpdateEmail')) {
	/**
	 * Send a user update email.
	 * 
	 * @return bool Indicates whether the email was send succesfully.
	 */
	function sendUserUpdateEmail(User $user): bool {
		$from = [
			'name' => 'Ledennotificatie',
			'email' => 'no-reply@hydrofiel.nl',
		];
		return sendEmail(
			$from,
			'secretaris@hydrofiel.nl',
			[],
			'Lid bewerkt',
			view('email/updateNotification', [
				'naam'  => $user->name,
				'email' => $user->email,
			]),
		);
	}
}

if (!function_exists('sendEmail')) {
	/**
	 * Sends an email.
	 */
	function sendEmail(array $from, string $to, array $bcc = [], string $subject, string $message, array $attachments = []): bool {
		$email = Services::email();
		$email->clear(true);

		/**
		 * Add attachments to email.
		 * 
		 * @var CodeIgniter\HTTP\Files\UploadedFile $attachment The attachment.
		 */
		foreach ($attachments as $attachment) {
			$email->attach($attachment->getTempName(), "", $attachment->getName());
		}

		return $email->setFrom($from['email'], $from['name'])
			->setTo($to)
			->setBCC($bcc)
			->setSubject($subject)
			->setMessage($message)
			->setMailType('html')
			->send();
	}
}
