<?php
namespace App\Entities;

use CodeIgniter\Entity;

class Page extends Entity {
	protected $casts = [
		'requiresLogIn' => 'boolean',
		'isVisible' => 'boolean',
		'isAccessible' => 'boolean',
		'isCMSPage' => 'boolean',
		'parentPageId' => '?integer',
		'pageId' => 'integer',
	];

	/**
	 * Automatically returns a different text based on whether the current user is English.
	 */
	public function getText(): string {
		return isEnglish() ? $this->contentEN : $this->contentNL;
	}
}