<?php
declare(strict_types=1);

namespace SydeUsersPlugin\Tests\Unit;

use SydeUsersPlugin\UserTable\Cache;
use PHPUnit\Framework\TestCase;
use Brain\Monkey;
use Brain\Monkey\Functions;

/**
 * Test Cache class
 */
class CacheTest extends TestCase {

	/**
	 * Cache instance
	 *
	 * @var Cache $cache
	 */
	private Cache $cache;

	/**
	 * Setup before each test
	 *
	 * @return void
	 */
	protected function setUp(): void {

		parent::setUp();
		Monkey\setUp();

		$this->cache = new Cache();
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
	 * Test get returns null when transient does not exist
	 */
	public function testGetReturnsNullWhenTransientIsFalse(): void {

		Functions\expect( 'get_transient' )
			->once()
			->withArgs( array( 'syde_users_plugin_test_key' ) )
			->andReturn( false );

		$result = $this->cache->get( 'test_key' );

		$this->assertNull( $result );
	}

	/**
	 * Test get returns value when transient exists
	 */
	public function testGetReturnsValueWhenTransientExists(): void {

		$expectedValue = array( 'test' => 'data' );

		Functions\expect( 'get_transient' )
			->once()
			->withArgs( array( 'syde_users_plugin_test_key' ) )
			->andReturn( $expectedValue );

		$result = $this->cache->get( 'test_key' );

		$this->assertEquals( $expectedValue, $result );
	}

	/**
	 * Test set calls set_transient with correct parameters
	 */
	public function testSetCallsSetTransientWithCorrectParameters(): void {

		$value      = array( 'test' => 'data' );
		$expiration = 3600;

		Functions\expect( 'set_transient' )
			->once()
			->withArgs( array( 'syde_users_plugin_test_key', $value, $expiration ) )
			->andReturn( true );

		$result = $this->cache->set( 'test_key', $value, $expiration );

		$this->assertTrue( $result );
	}

	/**
	 * Test delete calls delete_transient with correct key
	 */
	public function testDeleteCallsDeleteTransientWithCorrectKey(): void {

		Functions\expect( 'delete_transient' )
			->once()
			->withArgs( array( 'syde_users_plugin_test_key' ) )
			->andReturn( true );

		$result = $this->cache->delete( 'test_key' );

		$this->assertTrue( $result );
	}
}
