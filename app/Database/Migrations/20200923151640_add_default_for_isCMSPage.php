<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDefaultForIsCMSPage extends Migration {
	const TABLE = 'pages';

	public function up() {
		$this->forge->modifyColumn(self::TABLE, [
			'isCMSPage' => [
				'name' => 'isCMSPage',
				'type' => 'tinyint(1)',
				'null' => FALSE,
				'default' => 1,
			],
		]);
	}

	public function down() {
		$this->forge->modifyColumn(self::TABLE, [
			'isCMSPage' => [
				'name' => 'isCMSPage',
				'type' => 'tinyint(1)',
				'null' => FALSE
			],
		]);
	}
}
