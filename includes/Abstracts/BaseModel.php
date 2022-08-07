<?php
/**
 * Abstracts: BaseModel class
 *
 * @package    Job_Place
 * @since      5.8
 */

namespace Dearvn\JobPlace\Abstracts;

use Dearvn\JobPlace\Traits\InputSanitizer;
use Dearvn\JobPlace\Traits\Queryable;

/**
 * Base model class.
 *
 * @since 0.0.1
 */
abstract class BaseModel {

	use Queryable;
	use InputSanitizer;

	/**
	 * Variable database
	 *
	 * @var $db
	 */
	private $db;

	/**
	 * Table name.
	 *
	 * @since 0.0.1
	 *
	 * @var string
	 */
	protected $table;

	/**
	 * Primary key column of the table.
	 *
	 * @since 0.0.1
	 *
	 * @var string
	 */
	protected $primary_key = 'id';

	/**
	 * Created at column of the table.
	 *
	 * @since 0.0.1
	 *
	 * @var string
	 */
	protected $created_at_key = 'created_at';

	/**
	 * Updated at column of the table.
	 *
	 * @since 0.0.1
	 *
	 * @var string
	 */
	protected $updated_at_key = 'updated_at';

	/**
	 * Constructor.
	 *
	 * @since 0.0.1
	 */
	public function __construct() {
		global $wpdb;

		$this->db    = $wpdb;
		$this->table = $wpdb->prefix . $this->table;
	}

	/**
	 * Convert item dataset to array.
	 *
	 * @since 0.0.1
	 *
	 * @param object $item object.
	 *
	 * @return array
	 */
	abstract public static function to_array( object $item ): array;
}
