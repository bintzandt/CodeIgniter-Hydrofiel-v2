<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSocialEventType extends Migration {
	const TABLE = 'events';

	public function up() {
		$this->forge->modifyColumn(self::TABLE, [
			'kind' => [
				'name' => 'kind',
				'type' => 'ENUM',
				'constraint' => ['training', 'algemeen', 'toernooi', 'nszk', 'waterpolo_training', 'swim_training', 'social'],
			],
		]);
	}

	public function down() {
		$this->forge->modifyColumn(self::TABLE, ['kind' => ['name' => 'kind', 'type' => 'ENUM', 'constraint' => ['training', 'algemeen', 'toernooi', 'nszk', 'waterpolo_training', 'swim_training']]]);
	}
}
