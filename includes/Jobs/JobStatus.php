<?php
/**
 * Jobs: JobStatus class
 *
 * @package    Job_Place
 * @since      5.8
 */

namespace Dearvn\JobPlace\Jobs;

/**
 * JobStatus class.
 *
 * @since 0.0.1
 */
class JobStatus {

	/**
	 * Draft status.
	 *
	 * @since 0.0.1
	 */
	const DRAFT = 'draft';

	/**
	 * Published status.
	 *
	 * @since 0.0.1
	 */
	const PUBLISHED = 'published';

	/**
	 * Trashed status.
	 *
	 * @since 0.0.1
	 */
	const TRASHED = 'trashed';

	/**
	 * Get job status.
	 *
	 * @since 0.0.1
	 *
	 * @param object $job input value.
	 */
	public static function get_status_by_job( object $job ): string {
		if ( ! empty( $job->deleted_at ) ) {
			return self::TRASHED;
		}

		if ( $job->is_active ) {
			return self::PUBLISHED;
		}

		return self::DRAFT;
	}
}
