<?php

namespace App\Entities;

use CodeIgniter\Entity;

class Post extends Entity {
	protected $dates = ['post_timestamp'];

	public function getTitle(){
		return isEnglish() ? $this->post_title_en : $this->post_title_nl;
	}

	public function getText(){
		return isEnglish() ? $this->post_text_en : $this->post_text_nl;
	}
}
