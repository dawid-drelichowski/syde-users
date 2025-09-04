<?php
declare(strict_types=1);

namespace SydeUsersPlugin\UserTable;

use SydeUsersPlugin\Traits\LoggerTrait;

/**
 * Handles user data fetching from external API
 */
class UserRepository {

	use LoggerTrait;

	/**
	 * Base URL for the external API
	 *
	 * @var string API_BASE_URL
	 */
	private const API_BASE_URL = 'https://jsonplaceholder.typicode.com';

	/**
	 * Cache instance
	 *
	 * @var Cache $cache
	 */
	private Cache $cache;

	/**
	 * Constructor
	 */
	public function __construct() {

		$this->cache = new Cache();
	}

	/**
	 * Get all users from API
	 *
	 * @return array
	 */
	public function users(): array {

		$cacheKey = 'users_list';
		$users    = $this->cache->get( $cacheKey );

		if ( null !== $users ) {
			return $users;
		}

		$response = wp_remote_get(
			self::API_BASE_URL . '/users',
			array(
				'timeout' => 30,
				'headers' => array(
					'Accept' => 'application/json',
				),
			)
		);

		if ( is_wp_error( $response ) ) {
			$this->log( 'Failed to fetch users - ' . $response->get_error_message() );
			return array();
		}

		$responseCode = wp_remote_retrieve_response_code( $response );
		if ( 200 !== $responseCode ) {
			$this->log( 'API returned status code: ' . $responseCode );
			return array();
		}

		$body  = wp_remote_retrieve_body( $response );
		$users = json_decode( $body, true );

		if ( ! is_array( $users ) ) {
			$this->log( 'Invalid JSON response from users API' );
			return array();
		}

		$this->cache->set( $cacheKey, $users, HOUR_IN_SECONDS );

		return $users;
	}

	/**
	 * Get single user details from API
	 *
	 * @param int $userId User Id.
	 * @return array|null
	 */
	public function userDetails( int $userId ): ?array {

		$cacheKey    = 'user_details_' . $userId;
		$userDetails = $this->cache->get( $cacheKey );

		if ( null !== $userDetails ) {
			return $userDetails;
		}

		$response = wp_remote_get(
			self::API_BASE_URL . "/users/{$userId}",
			array(
				'timeout' => 30,
				'headers' => array(
					'Accept' => 'application/json',
				),
			)
		);

		if ( is_wp_error( $response ) ) {
			$this->log(
				'Failed to fetch user with id: ' . $userId . ' - ' . $response->get_error_message()
			);
			return null;
		}

		$responseCode = wp_remote_retrieve_response_code( $response );
		if ( 200 !== $responseCode ) {
			$this->log( 'API returned status code: ' . $responseCode . ' for user id ' . $userId );
			return null;
		}

		$body        = wp_remote_retrieve_body( $response );
		$userDetails = json_decode( $body, true );

		if ( ! is_array( $userDetails ) ) {
			$this->log( 'Invalid JSON response for user with id: ' . $userId );
			return null;
		}

		$this->cache->set( $cacheKey, $userDetails, HOUR_IN_SECONDS );

		return $userDetails;
	}
}
