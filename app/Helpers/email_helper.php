<?php
use App\Entities\User;
use Config\Services;

if (! function_exists('sendResetEmail')){
	/**
	 * Send a reset password email.
	 * 
	 * @return bool Indicates whether the email was send succesfully.
	 */
	function sendResetPasswordEmail( User $user ): bool {
		$email = Services::email();

		return $email->setFrom('no-reply@hydrofiel.nl', lang('Email.passwordResetSender'))
			->setTo($user->email)
			->setSubject(lang('Email.passwordResetSubject'))
			->setMessage(view(lang('Email.passwordResetPath'), [
				'recovery' => $user->recovery,
				'valid' => $user->recovery_valid,
			]))
			->setMailType('html')
			->send();
	}
}