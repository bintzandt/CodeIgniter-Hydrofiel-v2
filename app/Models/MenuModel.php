<?php
namespace App\Models;

use CodeIgniter\Model;

class MenuModel extends Model {
	protected $table = 'pagina';
	protected $primaryKey = 'id';

	protected $allowedFields = [
		'plaats', 'zichtbaar', 'submenu', 'bereikbaar', 'cmspagina', 'ingelogd',
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
			->select( 'id, naam, engelse_naam, ingelogd' )
			->where('submenu', 'A')
			->where('bereikbaar', 'ja')
			->orderBy('plaats')
			->get()
			->getCustomResultObject('App\Entities\MenuItem');
		
		foreach( $result as &$mainMenuItem ){
			$mainMenuItem->submenu = $this->getSubMenu($mainMenuItem->id);
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
			->select('id, naam, engelse_naam, ingelogd')
			->where('submenu', $mainMenuId)
			->where('bereikbaar', 'ja')
			->orderBy('plaats')
			->get()
			->getCustomResultObject('App\Entities\MenuItem');
	}
}