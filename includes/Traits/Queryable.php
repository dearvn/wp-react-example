<?php
/**
 * Traits: Queryable class
 *
 * @package    Job_Place
 * @since      5.8
 */

namespace Dearvn\JobPlace\Traits;

/**
 * Queryable trait.
 *
 * Manage basic DB query operations.
 *
 * @since 0.0.1
 */
trait Queryable {

	/**
	 * Get all rows by criteria.
	 *
	 * @since 0.0.1
	 *
	 * @param array $args input value.
	 *
	 * @return string|null|array
	 */
	public function all( array $args = array() ) {
		$columns  = ! empty( $args['columns'] ) ? sanitize_text_field( $args['columns'] ) : '*';
		$where    = ! empty( $args['where'] ) ? sanitize_text_field( $args['where'] ) : '';
		$orderby  = ! empty( $args['orderby'] ) ? sanitize_text_field( $args['orderby'] ) : $this->primary_key;
		$order    = ! empty( $args['order'] ) ? sanitize_text_field( $args['order'] ) : 'DESC';
		$count    = ! empty( $args['count'] ) ? boolval( $args['count'] ) : false;
		$page     = ! empty( $args['page'] ) ? absint( $args['page'] ) : 1;
		$per_page = ! empty( $args['per_page'] ) ? absint( $args['per_page'] ) : 10;

		if ( $count ) {
			return $this->db->get_var( "SELECT COUNT({$this->primary_key}) FROM {$this->table} {$where}" );
		}

		$sql  = "SELECT $columns FROM {$this->table} {$where}";
		$sql .= " ORDER BY $orderby $order";
		$sql .= " LIMIT $per_page";
		$sql .= $page ? ' OFFSET ' . ( $page - 1 ) * $per_page : '';

		return $this->db->get_results( $sql );
	}

	/**
	 * Get single row by id|slug.
	 *
	 * @since 0.0.1
	 *
	 * @param string $key input value.
	 * @param string $value input value.
	 * @param string $columns input value.
	 * @param bool   $is_single_val input value.
	 *
	 * @return string|null|object
	 */
	public function get_by( string $key, string $value, string $columns = '*', bool $is_single_val = false ): ?object {
		$value = is_numeric( $value ) ? absint( $value ) : sanitize_text_field( wp_unslash( $value ) );

		$prepared_sql = $this->db->prepare(
			"SELECT {$columns}
            FROM {$this->table}
            WHERE {$key} = %s",
			$value
		);

		if ( $is_single_val ) {
			return $this->db->get_var( $prepared_sql );
		}

		return $this->db->get_row( $prepared_sql );
	}

	/**
	 * Get single row by id.
	 *
	 * @since 0.0.1
	 *
	 * @param integer $id input value.
	 * @param string  $columns input value.
	 *
	 * @return string|null|object
	 */
	public function get( int $id, string $columns = '*' ): ?object {
		return $this->get_by( 'id', $id, $columns );
	}

	/**
	 * Create a new row.
	 *
	 * @since 0.0.1
	 *
	 * @param array $data input value.
	 * @param array $format input value.
	 *
	 * @return int|false The number of rows inserted, or false on error.
	 */
	public function create( array $data, array $format = array() ): ?int {
		if ( empty( $data ) ) {
			return false;
		}

		$inserted = $this->db->insert( $this->table, $data, $format );

		if ( $inserted ) {
			return $this->db->insert_id;
		}

		return false;
	}

	/**
	 * Update a row.
	 *
	 * @since 0.0.1
	 *
	 * @param array $data input value.
	 * @param array $where input value.
	 * @param array $format input value.
	 * @param array $where_format input value.
	 *
	 * @return integer|boolean
	 */
	public function update( array $data, array $where, array $format = array(), array $where_format = array() ): ?int {
		if ( empty( $data ) || empty( $where ) ) {
			return false;
		}

		$updated = $this->db->update( $this->table, $data, $where, $format, $format, $where_format );

		if ( $updated >= 0 ) {
			return $this->db->rows_affected;
		}

		return false;
	}

	/**
	 * Delete a row.
	 *
	 * @since 0.0.1
	 *
	 * @param array $where input value.
	 * @param array $where_format input value.
	 *
	 * @return integer|boolean
	 */
	public function delete( array $where, array $where_format = array() ): ?int {
		if ( empty( $where ) ) {
			return false;
		}

		return $this->db->delete( $this->table, $where, $where_format );
	}

	/**
	 * Execute query.
	 *
	 * @since 0.0.1
	 *
	 * @param string $sql input value.
	 *
	 * @return string|null|array
	 */
	public function query( string $sql ) {
		return $this->db->query( $sql );
	}
}
