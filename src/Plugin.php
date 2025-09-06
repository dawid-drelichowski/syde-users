<?php
declare(strict_types=1);

namespace SydeUsersPlugin;

use SydeUsersPlugin\Traits\PageDetectionTrait;
use SydeUsersPlugin\UserTable\Controller;
use SydeUsersPlugin\Ajax\UserDetailsHandler;

/**
 * Main plugin class
 */
final class Plugin {

	use PageDetectionTrait;

	/**
	 * User table controller instance
	 *
	 * @var Controller $controller
	 */
	private Controller $controller;

	/**
	 * AJAX handler instance
	 *
	 * @var UserDetailsHandler $ajaxHandler
	 */
	private UserDetailsHandler $ajaxHandler;

	/**
	 * Initialize the plugin
	 */
	public function init(): void {

		$this->controller  = new Controller();
		$this->ajaxHandler = new UserDetailsHandler();

		$this->setupHooks();
	}

	/**
	 * Setup WordPress hooks
	 */
	private function setupHooks(): void {

		add_action( 'init', array( $this, 'addRewriteRules' ) );

		add_action( 'template_redirect', array( $this->controller, 'handleRequest' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueueAssets' ) );

		/* AJAX hooks */
		add_action( 'wp_ajax_get_user_details', array( $this->ajaxHandler, 'handle' ) );
		add_action( 'wp_ajax_nopriv_get_user_details', array( $this->ajaxHandler, 'handle' ) );
	}

	/**
	 * Add custom rewrite rules
	 */
	public function addRewriteRules(): void {

		add_rewrite_rule(
			'^' . $this->usersEndpoint() . '/?$',
			'index.php?' . $this->usersQueryVar() . '=1',
			'top'
		);
		add_rewrite_tag( '%' . $this->usersQueryVar() . '%', '([^&]+)' );
	}

	/**
	 * Enqueue plugin assets
	 */
	public function enqueueAssets(): void {

		if ( ! $this->isUsersPage() ) {
			return;
		}

		wp_enqueue_style(
			'syde-users-table-css',
			SYDE_USERS_PLUGIN_URL . 'assets/css/user-table.css',
			array(),
			SYDE_USERS_PLUGIN_VERSION
		);

		wp_enqueue_script(
			'syde-users-table-js',
			SYDE_USERS_PLUGIN_URL . 'assets/js/user-table.js',
			array( 'jquery' ),
			SYDE_USERS_PLUGIN_VERSION,
			true
		);

		wp_localize_script(
			'syde-users-table-js',
			'sydeUsersAjax',
			array(
				'ajax_url' => admin_url( 'admin-ajax.php' ),
				'nonce'    => wp_create_nonce( 'user_details_nonce' ),
				'page_url' => $this->usersPageUrl(),
			)
		);
	}
}
