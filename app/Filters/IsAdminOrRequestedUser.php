<?php
namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

/**
 * Filter to check if the current user is an admin.
 */
class IsAdminOrRequestedUser implements FilterInterface {
	public function before(RequestInterface $request, $arguments = NULL){
		// Load the auth_helper if this function is not available.
		if (! function_exists('isAdmin')){
			helper('auth');
		}

		if (! function_exists('currentUserId')){
			helper('auth');
		}

		// Admin is always allowed to make this request.
		if ( isAdmin() ){
			return $request;
		}

		$segments = $request->uri->getSegments();
		$id = (int) array_pop( $segments );

		if ( $id !== currentUserId() ){
			throw new \RuntimeException(lang('Auth.notEnoughRights'));
		}
	}
	
	public function after(RequestInterface $request, ResponseInterface $response, $arguments = NULL){}
}