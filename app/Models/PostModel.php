<?php
namespace App\Models;

use CodeIgniter\Model;

class PostModel extends Model {
	protected $table = 'posts';
	protected $primaryKey = 'postId';
	
	protected $returnType = 'App\Entities\Post';
	protected $useTimeStamps = false;

	protected $allowedFields = ['titleNL','titleEN','textNL','textEN','image'];
}