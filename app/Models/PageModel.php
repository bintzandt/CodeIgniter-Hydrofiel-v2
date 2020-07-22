<?php
namespace App\Models;

use CodeIgniter\Model;

class PageModel extends Model {
	protected $table = 'pagina';
	protected $primaryKey = 'id';
	
	protected $returnType = 'App\Entities\Page';
	protected $useTimeStamps = false;

	protected $allowedFields = ['tekst','engels','zichtbaar','bereikbaar','ingelogd', 'submenu', 'naam', 'engelse_naam'];

	/**
	 * Builds a list of all the pages with their hierarchy. Some pages are subpages of a main item.
	 */
	public function getPagesHierarchical(){
		$result = $this->builder()
			->where('submenu', 'A')
			->orderBy('id')
			->orderBy('plaats')
			->get()
			->getCustomResultObject('App\Entities\Page');
		
		foreach( $result as &$mainPageItem ){
			$mainPageItem->subPages = $this->getSubPages($mainPageItem->id);
		}

		// Foreach loop by reference does not unset the last item, so we do it ourselves.
		unset($mainPageItem);

		return $result;
	}

	/**
	 * Gets the subPages for a mainPage.
	 */
	public function getSubPages( int $mainPageId ): array {
		return $this->builder()
			->where('submenu', $mainPageId)
			->orderBy('id')
			->orderBy('plaats')
			->get()
			->getCustomResultObject('App\Entities\Page');
	}
}