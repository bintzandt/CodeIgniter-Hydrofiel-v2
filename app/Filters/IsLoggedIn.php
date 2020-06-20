<?php
namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Config\Services;

/**
 * Filter to make sure that a user is signed in.
 */
class IsLoggedIn implements FilterInterface {
	public function before(RequestInterface $request){
		if (! function_exists('isLoggedIn')){
			helper('auth');
		}

		// Redirect to the sign in page.
		if ( ! isLoggedIn() ){
			redirect()->route('login');
		}
	}

	public function after(RequestInterface $request, ResponseInterface $response){}
}