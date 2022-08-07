<?php
/**
 * Abstracts: DBMigrator class
 *
 * @package    Job_Place
 * @since      5.8
 */

namespace Dearvn\JobPlace\Abstracts;

/**
 * Database migration class.
 *
 * Abstract class to handle database migration classes.
 */
abstract class DBMigrator {

	/**
	 * Migrate the database table.
	 *
	 * @since CAR_PULSE_SINCE
	 *
	 * @return void
	 * */
	abstract public static function migrate();
}
