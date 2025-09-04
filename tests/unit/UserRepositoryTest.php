<?php
declare(strict_types=1);

namespace SydeUsersPlugin\Tests\Unit;

use SydeUsersPlugin\UserTable\UserRepository;
use PHPUnit\Framework\TestCase;
use Brain\Monkey;
use Brain\Monkey\Functions;

/**
 * Test UserRepository class
 */
class UserRepositoryTest extends TestCase {

	/**
	 * User repository instance
	 *
	 * @var UserRepository $userRepository
	 */
	private UserRepository $userRepository;

	/**
	 * Setup before each test
	 *
	 * @return void
	 */
	protected function setUp(): void {

		parent::setUp();
		Monkey\setUp();

		/* Mock WordPress functions */
		Functions\when( 'HOUR_IN_SECONDS' )->justReturn( 3600 );
		Functions\when( 'get_transient' )->justReturn( false );
		Functions\when( 'set_transient' )->justReturn( true );
		Functions\when( 'delete_transient' )->justReturn( true );

		$this->userRepository = new UserRepository();
	}

	/**
	 * Teardown after each test
	 *
	 * @return void
	 */
	protected function tearDown(): void {

		Monkey\tearDown();
		parent::tearDown();
	}

	/**
	 * Test users returns array of users on success
	 */
	public function testUsersReturnsEmptyArrayOnWpError(): void {

		Functions\when( 'wp_remote_get' )
			->justReturn( new \WP_Error( 'http_error', 'Connection failed' ) );
		Functions\when( 'is_wp_error' )->justReturn( true );

		$result = $this->userRepository->users();

		$this->assertIsArray( $result );
		$this->assertEmpty( $result );
	}

	/**
	 * Test users returns empty array on non-200 response
	 */
	public function testUsersReturnsEmptyArrayOnNon200Response(): void {

		$mockResponse = array();
		Functions\when( 'wp_remote_get' )->justReturn( $mockResponse );
		Functions\when( 'is_wp_error' )->justReturn( false );
		Functions\when( 'wp_remote_retrieve_response_code' )->justReturn( 404 );

		$result = $this->userRepository->users();

		$this->assertIsArray( $result );
		$this->assertEmpty( $result );
	}

	/**
	 * Test users returns empty array on invalid JSON response
	 */
	public function testUsersReturnsEmptyArrayOnInvalidJson(): void {

		$mockResponse = array();
		Functions\when( 'wp_remote_get' )->justReturn( $mockResponse );
		Functions\when( 'is_wp_error' )->justReturn( false );
		Functions\when( 'wp_remote_retrieve_response_code' )->justReturn( 200 );
		Functions\when( 'wp_remote_retrieve_body' )->justReturn( 'invalid json' );

		$result = $this->userRepository->users();

		$this->assertIsArray( $result );
		$this->assertEmpty( $result );
	}

	/**
	 * Test userDetails returns null on WP_Error
	 */
	public function testUserDetailsReturnsNullOnWpError(): void {

		Functions\when( 'wp_remote_get' )
			->justReturn( new \WP_Error( 'http_error', 'Connection failed' ) );
		Functions\when( 'is_wp_error' )->justReturn( true );

		$result = $this->userRepository->userDetails( 1 );

		$this->assertNull( $result );
	}

	/**
	 * Test userDetails returns null on non-200 response
	 */
	public function testUserDetailsReturnsNullOnNon200Response(): void {

		$mockResponse = array();
		Functions\when( 'wp_remote_get' )->justReturn( $mockResponse );
		Functions\when( 'is_wp_error' )->justReturn( false );
		Functions\when( 'wp_remote_retrieve_response_code' )->justReturn( 404 );

		$result = $this->userRepository->userDetails( 1 );

		$this->assertNull( $result );
	}
}
