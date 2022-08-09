<?php
/**
 * Jobs: Manager class
 *
 * @package    Job_Place
 * @since      5.8
 */

namespace Dearvn\JobPlace\Jobs;

/**
 * Manager class.
 *
 * @since 0.0.1
 */
class Manager {

	/**
	 * Job class.
	 *
	 * @var Job
	 */
	public $job;

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->job = new Job();
	}

	/**
	 * Get all jobs by criteria.
	 *
	 * @since 0.0.1
	 *
	 * @param array $args input value.
	 * @return array|object|string
	 */
	public function all( array $args = array() ) {
		$defaults = array(
			'page'     => 1,
			'per_page' => 20,
			'orderby'  => 'id',
			'order'    => 'DESC',
			'search'   => '',
			'count'    => false,
			'where'    => array(),
		);

		$args = wp_parse_args( $args, $defaults );

		if ( ! empty( $args['search'] ) ) {
			global $wpdb;
			$like            = '%' . $wpdb->esc_like( sanitize_text_field( wp_unslash( $args['search'] ) ) ) . '%';
			$args['where'][] = $wpdb->prepare( ' title LIKE %s OR description LIKE %s ', $like, $like );
		}

		if ( ! empty( $args['where'] ) ) {
			$args['where'] = ' WHERE ' . implode( ' AND ', $args['where'] );
		} else {
			$args['where'] = '';
		}

		return $this->job->all( $args );
	}

	/**
	 * Get single job by id|slug.
	 *
	 * @since 0.0.1
	 *
	 * @param array $args input value.
	 * @return array|object|null
	 */
	public function get( array $args = array() ) {
		$defaults = array(
			'key'   => 'id',
			'value' => '',
		);

		$args = wp_parse_args( $args, $defaults );

		if ( empty( $args['value'] ) ) {
			return null;
		}

		return $this->job->get_by( $args['key'], $args['value'] );
	}

	/**
	 * Create a new job.
	 *
	 * @since 0.0.1
	 *
	 * @param array $data input value.
	 *
	 * @return int | WP_Error $id
	 */
	public function create( $data ) {
		// Prepare job data for database-insertion.
		$job_data = $this->job->prepare_for_database( $data );

		// Create job now.
		$job_id = $this->job->create(
			$job_data,
			array(
				'%s',
				'%s',
				'%s',
				'%d',
				'%d',
				'%d',
				'%d',
				'%s',
				'%s',
			)
		);

		if ( ! $job_id ) {
			return new \WP_Error( 'jobplace_job_create_failed', __( 'Failed to create job.', 'jobplace' ) );
		}

		/**
		 * Fires after a job has been created.
		 *
		 * @since 0.0.1
		 *
		 * @param int   $job_id
		 * @param array $job_data
		 */
		do_action( 'jobplace_jobs_created', $job_id, $job_data );

		return $job_id;
	}

	/**
	 * Update job.
	 *
	 * @since 0.0.1
	 *
	 * @param array $data input value.
	 * @param int   $job_id input value.
	 *
	 * @return int | WP_Error $id
	 */
	public function update( array $data, int $job_id ) {
		// Prepare job data for database-insertion.
		$job_data = $this->job->prepare_for_database( $data );

		// Update job.
		$updated = $this->job->update(
			$job_data,
			array(
				'id' => $job_id,
			),
			array(
				'%s',
				'%s',
				'%s',
				'%d',
				'%d',
				'%d',
				'%d',
				'%s',
				'%s',
			),
			array(
				'%d',
			)
		);

		if ( ! $updated ) {
			return new \WP_Error( 'jobplace_job_update_failed', __( 'Failed to update job.', 'jobplace' ) );
		}

		if ( $updated >= 0 ) {
			/**
			 * Fires after a job is being updated.
			 *
			 * @since 0.0.1
			 *
			 * @param int   $job_id
			 * @param array $job_data
			 */
			do_action( 'jobplace_jobs_updated', $job_id, $job_data );

			return $job_id;
		}

		return new \WP_Error( 'jobplace_job_update_failed', __( 'Failed to update the job.', 'jobplace' ) );
	}

	/**
	 * Delete jobs data.
	 *
	 * @since 0.0.1
	 *
	 * @param array|int $job_ids input value.
	 *
	 * @return int|WP_Error Return number or error.
	 */
	public function delete( $job_ids ) {
		if ( is_array( $job_ids ) ) {
			$job_ids = array_map( 'absint', $job_ids );
		} else {
			$job_ids = array( absint( $job_ids ) );
		}

		try {
			$this->job->query( 'START TRANSACTION' );

			$total_deleted = 0;
			foreach ( $job_ids as $job_id ) {
				$deleted = $this->job->delete(
					array(
						'id' => $job_id,
					),
					array(
						'%d',
					)
				);

				if ( $deleted ) {
					$total_deleted += intval( $deleted );
				}

				/**
				 * Fires after a job has been deleted.
				 *
				 * @since 0.0.1
				 *
				 * @param int $job_id
				 */
				do_action( 'jobplace_job_deleted', $job_id );
			}

			$this->job->query( 'COMMIT' );

			return $total_deleted;
		} catch ( \Exception $e ) {
			$this->job->query( 'ROLLBACK' );

			return new \WP_Error( 'jobplace-job-delete-error', $e->getMessage() );
		}
	}
}
