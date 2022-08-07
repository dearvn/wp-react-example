<?php
/**
 * Setup: Installer class
 *
 * @package    Job_Place
 * @since      5.8
 */

namespace Dearvn\JobPlace\Setup;

use Dearvn\JobPlace\Common\Keys;

/**
 * Class Installer.
 *
 * Install necessary database tables and options for the plugin.
 */
class Installer {

	/**
	 * Run the installer.
	 *
	 * @since 0.0.1
	 *
	 * @return void
	 */
	public function run(): void {
		// Update the installed version.
		$this->add_version();

		// Register and create tables.
		$this->register_table_names();
		$this->create_tables();

		// Run the database seeders.
		$seeder = new \Dearvn\JobPlace\Databases\Seeder\Manager();
		$seeder->run();
	}

	/**
	 * Register table names.
	 *
	 * @since 0.0.1
	 *
	 * @return void
	 */
	private function register_table_names(): void {
		global $wpdb;

		// Register the tables to wpdb global.
		$wpdb->jobplace_job_types = $wpdb->prefix . 'jobplace_job_types';
		$wpdb->jobplace_jobs      = $wpdb->prefix . 'jobplace_jobs';
	}

	/**
	 * Add time and version on DB.
	 *
	 * @since 0.0.1
	 *
	 * @return void
	 */
	public function add_version(): void {
		$installed = get_option( Keys::JOB_PLACE_INSTALLED );

		if ( ! $installed ) {
			update_option( Keys::JOB_PLACE_INSTALLED, time() );
		}

		update_option( Keys::JOB_PLACE_VERSION, CART_PULSE_VERSION );
	}

	/**
	 * Create necessary database tables.
	 *
	 * @since JOB_PLACE_
	 *
	 * @return void
	 */
	public function create_tables() {
		if ( ! function_exists( 'dbDelta' ) ) {
			require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		}

		// Run the database table migrations.
		\Dearvn\JobPlace\Databases\Migrations\JobsMigration::migrate();
	}
}
