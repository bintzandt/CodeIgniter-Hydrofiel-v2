<?php
namespace App\Entities;

use CodeIgniter\Entity;

class MenuItem extends Entity {
	protected $casts = [
		'pageId' => 'integer',
	];

	/**
	 * Getter for the name. Automatically translates between English and Dutch.
	 * 
	 * @return string Localized name of this MenuItem.
	 */
	public function getName(): string {
		return isEnglish() ? $this->nameEN : $this->nameNL;
	}
}