<?php
/**
 * Seeder: JobsSeeder class
 *
 * @package    Job_Place
 * @since      5.8
 */

namespace Dearvn\JobPlace\Databases\Seeder;

use Dearvn\JobPlace\Abstracts\DBSeeder;
use Dearvn\JobPlace\Common\Keys;

/**
 * Jobs Seeder class.
 *
 * Seed some fresh emails for initial startup.
 */
class JobsSeeder extends DBSeeder {

	/**
	 * Run Jobs seeder.
	 *
	 * @since 0.0.1
	 *
	 * @return void
	 */
	public function run() {
		global $wpdb;

		// Check if there is already a seeder runs for this plugin.
		$already_seeded = (bool) get_option( Keys::JOB_SEEDER_RAN, false );
		if ( $already_seeded ) {
			return;
		}

		// Generate some jobs.
		$jobs = array(
			array(
				'title'       => 'First Job Post',
				'slug'        => 'first-job-post',
				'description' => 'This is a simple job post.',
				'is_active'   => 1,
				'company_id'  => 1,
				'job_type_id' => 1,
				'created_by'  => get_current_user_id(),
				'created_at'  => current_datetime()->format( 'Y-m-d H:i:s' ),
				'updated_at'  => current_datetime()->format( 'Y-m-d H:i:s' ),
			),
		);

		// Create each of the jobs.
		foreach ( $jobs as $job ) {
			$wpdb->insert(
				$wpdb->prefix . 'jobplace_jobs',
				$job
			);
		}

		// Update that seeder already runs.
		update_option( Keys::JOB_SEEDER_RAN, true );
	}
}
