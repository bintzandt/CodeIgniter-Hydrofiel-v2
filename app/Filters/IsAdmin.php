IsAdminOrRequestedUser<?php
namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

/**
 * Filter to check if the current user is an admin.
 */
class IsAdmin implements FilterInterface {
	public function before(RequestInterface $request){
		// Load the auth_helper if this function is not available.
		if (! function_exists('isAdmin')){
			helper('auth');
		}

		if (! isAdmin()){
			throw new \RuntimeException(lang('Auth.notEnoughRights'));
		}
	}
	
	public function after(RequestInterface $request, ResponseInterface $response){}
}