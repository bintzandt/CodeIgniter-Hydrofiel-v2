<?php
namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController {
	/**
	 * Model for interacting with users.
	 */
	protected UserModel $users;

	public function __construct(){
		helper(['form', 'email']);

		$this->users = new UserModel();
	}

	//--------------------------------------------------------------------------
	// Login/out
	//--------------------------------------------------------------------------
	/**
	 * Displays the login form, or redirects the user to their destination if they are already logged in.
	 */
	public function login(){
		// No need to show a login form if the user is already logged in
		if ( isLoggedIn() ){
			$redirectURL = session('redirectURL') ?? '/';
			$this->session->remove('redirectURL');

			return redirect()->to($redirectURL);
		}

		// Set a return URL if none is specified
		$this->session->set('redirectURL', $this->session->redirectURL ?? previous_url() ?? '/');

		return view('auth/login');
	}

	/**
	 * Attempts to verify the user's credentials through a POST request.
	 */
	public function attemptLogin(){
		$rules = [
			'email' => 'required',
			'password' => 'required',
		];

		if (!$this->validate($rules)){
			return redirect()->back()->withInput();
		}

		$email = $this->request->getPost('email');
		$password = $this->request->getpost('password');

		$user = $this->users->where('email', $email)->first();

		if (!$user || !$user->attemptLogin($password)){
			return redirect()->back()->withInput()->with('error', lang('Auth.errorLogInDataIncorrect'));
		}

		$redirectURL = session('redirectURL') ?? '/';
		$this->session->remove('redirectURL');

		return redirect()->to($redirectURL);
	}

	/**
	 * Log the user out.
	 */
	public function logout(){
		if ( isLoggedIn() ){
			$this->session->destroy();
		}

		return redirect()->to('/');
	}

	//--------------------------------------------------------------------------
	// Forgot password
	//--------------------------------------------------------------------------
	/**
	 * Displays the forgot password form.
	 */
	public function forgotPassword(){
		return view('auth/forgot');
	}

	/**
	 * Attempts to find a user with that email and send the password reset instructions.
	 */
	public function attemptForgot(){
		$email = $this->request->getPost('email');

		$user = $this->users->where('email', $email)->first();
		
		if ( ! $user ){
			return redirect()->back()->with('error', lang('Auth.errorNoUser'));
		}

		// Save the reset hash
		$user->generateResetHash();
		$this->users->save($user);
		
		$sent = sendResetPasswordEmail( $user );

		if (!$sent){
			return redirect()->back()->withInput()->with('error', lang('Error.unknownError'));
		}

		return redirect()->route('reset-password')->with('success', lang('Auth.forgotEmailSent'));
	}

	/**
	 * Displays the Reset Password form.
	 */
	public function resetPassword(){
		$token = $this->request->getGet('token');

		return view('auth/reset', ['token' => $token]);
	}

	/**
	 * Verifies the token with the email and saves the new password.
	 */
	public function attemptReset(){
		$rules = [
			'token' => 'required',
			'email' => 'required|valid_email',
			'password' => 'required',
			'pass_confirm' => 'required|matches[password]',
		];

		if (!$this->validate($rules)){
			return redirect()->back()->withInput();
		}

		$email = $this->request->getPost('email');
		$password = $this->request->getPost('password');
		$token = $this->request->getPost('token');

		$user = $this->users
			->where('email', $email)
			->where('recoveryToken', $token)
			->first();
		
		if (!$user){
			return redirect()->back()->withInput()->with('error', lang('Auth.errorNoUser'));
		}

		if (!empty($user->recoveryTokenValid) && time() > $user->recoveryTokenValid->getTimestamp()){
			return redirect()->back()->withInput()->with('error', lang('Auth.resetTokenExpired'));
		}

		$user->passwordHash = $password;
		$this->users->save($user);

		return redirect()->route('login')->with('success', lang('Auth.resetSuccess'));
	}
}