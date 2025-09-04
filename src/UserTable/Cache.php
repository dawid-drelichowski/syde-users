<?php
declare(strict_types=1);

namespace SydeUsersPlugin\UserTable;

/**
 * Simple cache wrapper using WordPress transients
 */
final class Cache {

	/**
	 * Cache group prefix
	 *
	 * @var string CACHE_GROUP
	 */
	private const CACHE_GROUP = 'syde_users_plugin';

	/**
	 * Get cached value
	 *
	 * @param string $key Cache key.
	 * @return mixed|null
	 */
	public function get( string $key ): mixed {

		$cacheKey = $this->getCacheKey( $key );
		$value    = get_transient( $cacheKey );

		return false === $value ? null : $value;
	}

	/**
	 * Set cached value
	 *
	 * @param string $key Cache key.
	 * @param mixed  $value Value to cache.
	 * @param int    $expiration Expiration time in seconds.
	 * @return bool
	 */
	public function set( string $key, mixed $value, int $expiration ): bool {

		$cacheKey = $this->getCacheKey( $key );
		return set_transient( $cacheKey, $value, $expiration );
	}

	/**
	 * Delete cached value
	 *
	 * @param string $key Cache key.
	 * @return bool
	 */
	public function delete( string $key ): bool {

		$cacheKey = $this->getCacheKey( $key );
		return delete_transient( $cacheKey );
	}

	/**
	 * Clear all plugin cache
	 *
	 * @return void
	 */
	public function flush(): void {

		global $wpdb;

		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
		$wpdb->query(
			$wpdb->prepare(
				"DELETE FROM {$wpdb->options} 
				WHERE option_name LIKE %s 
					OR option_name LIKE %s",
				'_transient_' . self::CACHE_GROUP . '_%',
				'_transient_timeout_' . self::CACHE_GROUP . '_%'
			)
		);
	}

	/**
	 * Generate cache key with group prefix
	 *
	 * @param string $key Base key.
	 * @return string
	 */
	private function getCacheKey( string $key ): string {

		return self::CACHE_GROUP . '_' . $key;
	}
}
