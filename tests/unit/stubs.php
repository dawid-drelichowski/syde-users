<?php
declare(strict_types=1);

// phpcs:disable Syde.PHP.DisallowTopLevelDefine.Found

if ( ! class_exists( 'WP_Error' ) ) {
	/**
	 * Stub for WP_Error class to prevent errors during unit tests
	 */
	class WP_Error {
		/**
		 * Constructor stub
		 *
		 * @param string $code Error code.
		 * @param string $message Error message.
		 *
		 * @codeCoverageIgnore
		 */
		public function __construct( $code = '', $message = '' ) {}

		/**
		 * Stub for get_error_message method
		 *
		 * @return string Error message.
		 *
		 * @codeCoverageIgnore
		 */
		public function get_error_message(): string { // phpcs:ignore Syde.Classes.DisallowGetterSetter.GetterFound

			return 'WP_Error::get_error_message() stub';
		}
	}
}
