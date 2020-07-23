<?php
namespace App\Models;

use CodeIgniter\Model;

class MenuModel extends Model {
	protected $table = 'pages';
	protected $primaryKey = 'pageId';

	protected $allowedFields = [
		'isVisible', 'parentPageId', 'isAccessible', 'isCMSPage', 'requiresLogIn',
	];

	protected $useTimestamps = false;


	/**
	 * Gets an array of all MenuItems.
	 * 
	 * If an item has a submenu, this is populated under 'submenu'.
	 * 
	 * @return MenuItem[] The complete menu.
	 */
	public function getMenu(){
		$result = $this->builder()
			->select( 'pageId, nameNL, nameEN, requiresLogIn' )
			->where('parentPageId', null)
			->where('isAccessible', true)
			->orderBy('pageId')
			->get()
			->getCustomResultObject('App\Entities\MenuItem');
		
		foreach( $result as &$mainMenuItem ){
			$mainMenuItem->submenu = $this->getSubMenu($mainMenuItem->pageId);
		}

		// Foreach loop by reference does not unset the last item, so we do it ourselves.
		unset($mainMenuItem);

		return $result;
	}

	/**
	 * Gets the SubMenu for a mainMenu.
	 * 
	 * @return MenuItem[] An array of submenu items.
	 */
	public function getSubMenu( int $mainMenuId ){
		return $this->builder()
			->select('pageId, nameNL, nameEN, requiresLogIn')
			->where('parentPageId', $mainMenuId)
			->where('isAccessible', true)
			->orderBy('pageId')
			->get()
			->getCustomResultObject('App\Entities\MenuItem');
	}
}