<?php
declare(strict_types=1);

namespace SydeUsersPlugin\Ajax;

use SydeUsersPlugin\Traits\PageDetectionTrait;
use SydeUsersPlugin\UserTable\UserRepository;

/**
 * Handles AJAX requests for user details
 */
class UserDetailsHandler {

	use PageDetectionTrait;

	/**
	 * User repository instance
	 *
	 * @var UserRepository $userRepository
	 */
	private UserRepository $userRepository;

	/**
	 * Constructor
	 */
	public function __construct() {

		$this->userRepository = new UserRepository();
	}

	/**
	 * Handle AJAX request for user details
	 */
	public function handle(): void {

		$nonce = isset( $_POST['nonce'] )
			? sanitize_text_field( wp_unslash( $_POST['nonce'] ) )
			: '';
		if ( ! wp_verify_nonce( $nonce, 'user_details_nonce' ) ) {
			wp_die( 'Invalid nonce', 'Unauthorized', array( 'response' => 401 ) );
		}

		$userId = isset( $_POST['user_id'] ) ? absint( $_POST['user_id'] ) : 0;

		if ( $userId <= 0 ) {
			wp_send_json_error( 'Invalid user Id' );
			return;
		}

		$userDetails = $this->userRepository->userDetails( $userId );

		if ( null === $userDetails ) {
			wp_send_json_error( 'Failed to fetch user details' );
			return;
		}

		wp_send_json_success(
			array(
				'html' => $this->renderUserDetails( $userDetails ),
			)
		);
	}

	/**
	 * Render user details HTML
	 *
	 * @param array $user User details.
	 * @return string Rendered HTML
	 */
	private function renderUserDetails( array $user ): string { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.Found

		ob_start();
		$templatePath = SYDE_USERS_PLUGIN_PATH . 'templates/user-details.php';
		if ( file_exists( $templatePath ) ) {
			include $templatePath;
		}
		return ob_get_clean();
	}
}
