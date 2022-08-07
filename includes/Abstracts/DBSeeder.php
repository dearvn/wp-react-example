<?php
/**
 * Abstracts: DBSeeder class
 *
 * @package    Job_Place
 * @since      5.8
 */

namespace Dearvn\JobPlace\Abstracts;

/**
 * Abstract class to handle the seeder classes.
 *
 * @since 0.0.1
 */
abstract class DBSeeder {

	/**
	 * Run the seeders of the database.
	 *
	 * @since 0.0.1
	 *
	 * @return void
	 */
	abstract public function run();
}
