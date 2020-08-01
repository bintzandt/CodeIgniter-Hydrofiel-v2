<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAdditionalCommentToDetails extends Migration {
	const TABLE = 'registrationDetails';

	public function up() {
		$this->forge->addColumn(self::TABLE, [
			'additionalComment' => [
				'type' => 'TEXT',
				'default' => ''
			],
		]);
	}

	public function down() {
		$this->forge->dropColumn(self::TABLE, 'additionalComment');
	}
}
