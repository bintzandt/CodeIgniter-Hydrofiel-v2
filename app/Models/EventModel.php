<?php
namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

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

	/**
	 * Returns a list of upcoming events.
	 * 
	 * @param int $limit An optional parameter that defines how many events we want.
	 */
	public function getUpcomingEvents( ?int $limit = null ): array {
		return $this
			->where('van >=', Time::now())
			->limit($limit)
			->orderBy('van', 'ASC')
			->find();
	}

	/**
	 * Returns a list of passed events.
	 * 
	 * @param int $limit An optional parameter that defines how many events we want.
	 */
	public function getPassedEvents(?int $limit = null){
		return $this
			->where('van <', Time::now())
			->limit($limit)
			->orderBy('van', 'DESC')
			->find();
	}
}