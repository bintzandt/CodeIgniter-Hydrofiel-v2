<?php
namespace App\Entities;

use CodeIgniter\Entity;

class Page extends Entity {
	protected $dataMap = [
		'requiresLogIn' => 'ingelogd',
	];

	protected $casts = [
		'ingelogd' => 'boolean',
	];

	public function getText(): string {
		return isEnglish() ? $this->engels : $this->tekst;
	}
}