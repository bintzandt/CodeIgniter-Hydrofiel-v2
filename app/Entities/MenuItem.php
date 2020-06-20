<?php
namespace App\Entities;

use CodeIgniter\Entity;

class MenuItem extends Entity {
	/**
	 * Getter for the name. Automatically translates between English and Dutch.
	 * 
	 * @return string Localized name of this MenuItem.
	 */
	public function getName(): string {
		return isEnglish() ? $this->engelse_naam : $this->naam;
	}
}