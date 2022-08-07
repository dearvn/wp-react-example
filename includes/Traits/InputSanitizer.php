<?php
/**
 * Traits: InputSanitizer class
 *
 * @package    Job_Place
 * @since      5.8
 */

namespace Dearvn\JobPlace\Traits;

/**
 * Trait: Input Sanitizer.
 *
 * It will sanitize any input value based on type.
 */
trait InputSanitizer {

	/**
	 * Sanitize settings request.
	 *
	 * @since 0.0.1
	 *
	 * @param mixed  $value input value.
	 * @param string $type input value.
	 *
	 * @return mixed $sanitized value
	 */
	public function sanitize( $value, string $type ) {
		$sanitized = '';

		switch ( $type ) {
			case 'text':
			case 'textarea':
				$sanitized = sanitize_text_field( wp_unslash( $value ) );
				break;

			case 'number':
				$sanitized = absint( wp_unslash( $value ) );
				break;

			case 'email':
				$sanitized = sanitize_email( wp_unslash( $value ) );
				break;

			case 'switch':
				$sanitized = (bool) wp_unslash( $value );
				break;

			case 'block':
				// Sanitize gutenberg block data.
				// We're not sanitizing it, now, when we're showing it,
				// We'll use gutenberg's own way for rendering blocks.
				$sanitized = $value;
				break;

			default:
				$sanitized = $value;
				break;
		}

		return $sanitized;
	}
}
