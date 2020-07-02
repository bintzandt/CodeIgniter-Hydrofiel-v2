<?php
namespace App\Models;

use CodeIgniter\Model;

class PostModel extends Model {
	protected $table = 'posts';
	protected $primaryKey = 'post_id';
	
	protected $returnType = 'object';
	protected $useTimeStamps = false;

	protected $allowedFields = ['post_title_nl','post_title_en','post_text_nl','post_text_en','post_image'];
}