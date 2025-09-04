<?php
declare(strict_types=1);

namespace SydeUsersPlugin\Traits;

/**
 * Page detection trait - provides common page detection methods
 */
trait PageDetectionTrait {

	/**
	 * Query var name for users table page
	 */
	private const USERS_QUERY_VAR = 'syde_users';

	/**
	 * Endpoint slug for users table
	 */
	private const USERS_ENDPOINT = 'syde-users';

	/**
	 * Check if current page is users table page
	 */
	protected function isUsersPage(): bool {

		return get_query_var( self::USERS_QUERY_VAR ) === '1';
	}

	/**
	 * Check if we're on any plugin page
	 */
	protected function isPluginPage(): bool {

		return $this->isUsersPage();
	}

	/**
	 * Get the query var name for users page
	 */
	protected function usersQueryVar(): string {

		return self::USERS_QUERY_VAR;
	}

	/**
	 * Get the endpoint slug for users page
	 */
	protected function usersEndpoint(): string {

		return self::USERS_ENDPOINT;
	}

	/**
	 * Get the full URL for users page
	 */
	protected function usersPageUrl(): string {

		return home_url( '/' . self::USERS_ENDPOINT . '/' );
	}

	/**
	 * Check if current request URI matches users endpoint (for debugging)
	 */
	protected function isUsersEndpointRequested(): bool {
		// phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized,WordPress.Security.ValidatedSanitizedInput.MissingUnslash
		$requestUri = $_SERVER['REQUEST_URI'] ?? '';
		return str_contains( $requestUri, '/' . self::USERS_ENDPOINT );
	}
}
