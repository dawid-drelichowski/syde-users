<?php
declare(strict_types=1);

namespace SydeUsersPlugin\Traits;

/**
 * Logger trait - provides simple logging functionality
 */
trait LoggerTrait {
	/**
	 * Log a message to the error log if WP_DEBUG is enabled
	 *
	 * @param mixed $message Message to log.
	 * @return void
	 */
	protected function log( mixed $message ): void {

		if ( ! defined( 'WP_DEBUG' ) || ! WP_DEBUG ) {
			return;
		}

		// phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_print_r
		$log = is_array( $message ) || is_object( $message ) ? print_r( $message, true ) : $message;
        // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log
		error_log( 'Syde Users Plugin: ' . $log );
	}
}
