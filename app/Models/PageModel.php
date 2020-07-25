<?php
namespace App\Models;

use CodeIgniter\Model;

class PageModel extends Model {
	protected $table = 'pages';
	protected $primaryKey = 'pageId';
	
	protected $returnType = 'App\Entities\Page';
	protected $useTimeStamps = false;

	protected $allowedFields = ['nameNL', 'nameEN', 'contentNL', 'contentEN', 'isVisible','isAccessible','requiresLogIn', 'parentPageId'];

	/**
	 * Builds a list of all the pages with their hierarchy. Some pages are subpages of a main item.
	 */
	public function getPagesHierarchical(){
		$result = $this->builder()
			->where('parentPageId', null)
			->orderBy('pageId')
			->get()
			->getCustomResultObject('App\Entities\Page');
		
		foreach( $result as &$mainPageItem ){
			$mainPageItem->subPages = $this->getSubPages($mainPageItem->pageId);
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
			->where('parentPageId', $mainPageId)
			->orderBy('pageId')
			->get()
			->getCustomResultObject('App\Entities\Page');
	}
}