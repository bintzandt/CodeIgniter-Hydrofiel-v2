<?php
if(!function_exists('getEditIcon')){
	/**
	 * Gets the edit icon.
	 *
	 * Checks if the current user is allowed to edit this profile.
	 */
	function getEditIcon( int $id ){
		if (currentUserId() === $id || isAdmin()){
			return sprintf('<a href="/user/edit/%d"><i class="fa fa-pencil-alt"></i></a>', $id );
		}
	}
}