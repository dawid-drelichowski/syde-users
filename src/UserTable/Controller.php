<?php
declare(strict_types=1);

namespace SydeUsersPlugin\UserTable;

use SydeUsersPlugin\Traits\PageDetectionTrait;

/**
 * Handles the user table display logic
 */
class Controller {

	use PageDetectionTrait;

	/**
	 * User repository instance
	 *
	 * @var UserRepository $userRepository
	 */
	private UserRepository $userRepository;

	/**
	 * §Constructor
	 */
	public function __construct() {

		$this->userRepository = new UserRepository();
	}

	/**
	 * Handle the request for users table page
	 */
	public function handleRequest(): void {

		if ( ! $this->isUsersPage() ) {
			return;
		}

		$users = $this->userRepository->users();
		$this->renderUsersTable( $users );
		exit;
	}

	/**
	 * Render the users table
	 *
	 * @param array $users List of users to display.
	 * @return void
	 */
	private function renderUsersTable( array $users ): void { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.Found

		ob_start();

		$templatePath = SYDE_USERS_PLUGIN_PATH . 'templates/user-table.php';
		if ( file_exists( $templatePath ) ) {
			include $templatePath;
		}
		$content = ob_get_clean();

		header( 'Content-Type: text/html; charset=UTF-8' );
		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo $content;
	}
}
