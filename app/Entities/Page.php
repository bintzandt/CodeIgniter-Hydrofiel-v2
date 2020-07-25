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

	public function getText(): string {
		return isEnglish() ? $this->contentEN : $this->contentNL;
	}
}