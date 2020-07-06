<?php
namespace App\Libraries;

use \App\Models\MenuModel;

/**
 * Menu library.
 */
class Menu {
	/**
	 * Gets the HTML for the complete menu so that it can be rendered inside a template.
	 */
	public function getMenu(){
		$menuModel = new MenuModel();
		$data = [
			'hoofdmenus' => $menuModel->getMenu(),
		];
		return view('templates/menu/default', $data);
	}
}