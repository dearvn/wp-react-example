<?php
/**
 * Seeder: Manager class
 *
 * @package    Job_Place
 * @since      5.8
 */

namespace Dearvn\JobPlace\Databases\Seeder;

/**
 * Database Seeder class.
 *
 * It'll seed all of the seeders.
 */
class Manager {

	/**
	 * Run the database seeders.
	 *
	 * @since 0.0.1
	 *
	 * @return void
	 * @throws \Exception Return error.
	 */
	public function run() {
		$seeder_classes = array(
			\Dearvn\JobPlace\Databases\Seeder\JobsSeeder::class,
		);

		foreach ( $seeder_classes as $seeder_class ) {
			$seeder = new $seeder_class();
			$seeder->run();
		}
	}
}
