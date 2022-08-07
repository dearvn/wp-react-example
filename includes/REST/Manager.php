<?php
/**
 * REST: Manager class
 *
 * @package    Job_Place
 * @since      5.8
 */

namespace Dearvn\JobPlace\REST;

/**
 * API Manager class.
 *
 * All API classes would be registered here.
 *
 * @since 0.0.1
 */
class Manager {

	/**
	 * Class dir and class name mapping.
	 *
	 * @var array
	 *
	 * @since 0.0.1
	 */
	protected $class_map;

	/**
	 * Constructor.
	 */
	public function __construct() {
		if ( ! class_exists( 'WP_REST_Server' ) ) {
			return;
		}

		$this->class_map = apply_filters(
			'jobplace_rest_api_class_map',
			array(
				JOB_PLACE_DIR . '/includes/REST/JobTypesController.php' => 'Dearvn\JobPlace\REST\JobTypesController',
				JOB_PLACE_DIR . '/includes/REST/JobsController.php' => 'Dearvn\JobPlace\REST\JobsController',
			)
		);

		// Init REST API routes.
		add_action( 'rest_api_init', array( $this, 'register_rest_routes' ), 10 );
	}

	/**
	 * Register REST API routes.
	 *
	 * @since 0.0.1
	 *
	 * @return void
	 */
	public function register_rest_routes(): void {
		foreach ( $this->class_map as $file_name => $controller ) {
			require_once $file_name;
			$this->$controller = new $controller();
			$this->$controller->register_routes();
		}
	}
}
