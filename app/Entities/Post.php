<?php

namespace App\Entities;

use CodeIgniter\Entity;

class Post extends Entity {
	protected $dates = ['timestamp'];

	public function getTitle(){
		return isEnglish() ? $this->titleEN : $this->titleNL;
	}

	public function getText(){
		return isEnglish() ? $this->textEN : $this->textNL;
	}
}
