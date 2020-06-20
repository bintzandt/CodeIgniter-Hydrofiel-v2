<?php
namespace App\Models;

use CodeIgniter\Model;

class PageModel extends Model {
	protected $table = 'pagina';
	protected $primaryKey = 'id';
	
	protected $returnType = 'App\Entities\Page';
	protected $useTimeStamps = false;

	protected $allowedFields = ['tekst','engels','zichtbaar','bereikbaar','ingelogd'];
}