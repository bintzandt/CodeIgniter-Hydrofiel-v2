<?php
namespace App\Models;

use CodeIgniter\Model;

class EventModel extends Model {
	protected $table = 'agenda';
	protected $primaryKey = 'event_id';
	
	protected $returnType = 'App\Entities\Event';
	protected $useTimeStamps = false;

	protected $allowedFields = [
		'nl_naam',
		'en_naam',
		'betalen',
		'locatie',
		'link',
		'nl_omschrijving',
		'en_omschrijving',
		'van',
		'tot',
		'inschrijfsysteem',
		'inschrijfdeadline',
		'afmelddeadline',
		'maximum',
		'soort',
		'slagen',
	];
}