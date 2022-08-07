<?php
/**
 * Admin: Menu class
 *
 * @package    Job_Place
 * @since      5.8
 */

namespace Dearvn\JobPlace\Admin;

/**
 * Admin Menu class.
 *
 * Responsible for managing admin menus.
 */
class Menu {

	/**
	 * Constructor.
	 *
	 * @since 0.0.1
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'init_menu' ) );
	}

	/**
	 * Init Menu.
	 *
	 * @since 0.0.1
	 *
	 * @return void
	 */
	public function init_menu() {
		global $submenu;

		$slug          = JOB_PLACE_SLUG;
		$menu_position = 50;
		$capability    = 'manage_options';

		add_menu_page( esc_attr__( 'Job Place', 'jobplace' ), esc_attr__( 'Job Place', 'jobplace' ), $capability, $slug, array( $this, 'plugin_page' ), 'dashicons-filter', $menu_position );

		if ( current_user_can( $capability ) ) {
			$submenu[ $slug ][] = array( esc_attr__( 'Home', 'jobplace' ), $capability, 'admin.php?page=' . $slug . '#/' ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
			$submenu[ $slug ][] = array( esc_attr__( 'Jobs', 'jobplace' ), $capability, 'admin.php?page=' . $slug . '#/jobs' ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
		}
	}

	/**
	 * Render the plugin page.
	 *
	 * @since 0.0.1
	 *
	 * @return void
	 */
	public function plugin_page() {
		require_once JOB_PLACE_TEMPLATE_PATH . '/app.php';
	}
}
