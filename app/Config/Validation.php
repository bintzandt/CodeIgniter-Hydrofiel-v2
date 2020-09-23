<?php namespace Config;

class Validation
{
	//--------------------------------------------------------------------
	// Setup
	//--------------------------------------------------------------------

	/**
	 * Stores the classes that contain the
	 * rules that are available.
	 *
	 * @var array
	 */
	public $ruleSets = [
		\CodeIgniter\Validation\Rules::class,
		\CodeIgniter\Validation\FormatRules::class,
		\CodeIgniter\Validation\FileRules::class,
		\CodeIgniter\Validation\CreditCardRules::class,
	];

	/**
	 * Specifies the views that are used to display the
	 * errors.
	 *
	 * @var array
	 */
	public $templates = [
		'list'   => 'errors/list',
		'single' => 'errors/single',
	];

	//--------------------------------------------------------------------
	// Rules
	//--------------------------------------------------------------------
	public $saveEvent = [
		'eventId' => 'if_exist|integer',
		'nameNL' => 'required|string',
		'descriptionNL' => 'required|string',
		'nameEN' => 'required|string',
		'descriptionEN' => 'required|string',
		'kind' => 'required|in_list[nszk,algemeen,toernooi,social]',
		'from' => 'required|valid_date[d-m-Y H:i]',
		'until' => 'required|valid_date[d-m-Y H:i]',
		'link' => 'if_exist|string',
		'location' => 'if_exist|string',
		'needsRegistration' => 'required|in_list[0,1]',
		'needsPayment' => 'if_exist|in_list[0,1]',
		'maximumRegistrations' => 'integer',
	];
	
	/**
	 * Validates that the following are true:
	 * - 'email' is required and must be a valid email address
	 * - 'name' is requred and must be a string
	 * - If 'preferEnglish' is present, it must be equal to 'Ja'
	 */
	public $addFriend = [
		'email' => 'required|valid_email',
		'name'	=> 'required|string',
		'preferEnglish' => 'if_exist|in_list[Ja]'
	];

	public $login = [
		'email' => 'required',
		'password' => 'required',
	];

	public $reset = [
		'token' => 'required',
		'email' => 'required|valid_email',
		'password' => 'required',
		'pass_confirm' => 'required|matches[password]',
	];

	public $saveUser = [
		'email' => 'required|valid_email',
		'password2' => 'matches[password1]',
	];
}
