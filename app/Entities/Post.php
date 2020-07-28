<?php

namespace App\Entities;

use CodeIgniter\Entity;

class Post extends Entity {
	protected $dates = ['timestamp'];

	/**
	 * Returns a translated Post title.
	 */
	public function getTitle(){
		return isEnglish() ? $this->titleEN : $this->titleNL;
	}

	/**
	 * Returns a translated Post text.
	 */
	public function getText(){
		return isEnglish() ? $this->textEN : $this->textNL;
	}
}
