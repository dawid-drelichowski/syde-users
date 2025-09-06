<?php
/**
 * Plugin Name: Syde Users
 * Description: A WordPress plugin to display users from external API in a table format.
 * Version: 1.0.0
 * Author: Dawid Drelichowski
 * Requires PHP: 8.2
 * License: GPL-2.0-or-later
 */

// phpcs:disable Syde.PHP.DisallowTopLevelDefine.Found

/* Prevent direct access */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/* Plugin constants */
define( 'SYDE_USERS_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'SYDE_USERS_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
const SYDE_USERS_TEXTDOMAIN     = 'syde-users';
const SYDE_USERS_PLUGIN_VERSION = '1.0.0';

/* Composer autoloader */
$autoloaderPath = SYDE_USERS_PLUGIN_PATH . 'vendor/autoload.php';
if ( ! file_exists( $autoloaderPath ) ) {
	return;
}

require_once $autoloaderPath;

use SydeUsersPlugin\Plugin;

/* Bootstrap the plugin */
add_action(
	'plugins_loaded',
	static function (): void {
		if ( class_exists( 'SydeUsersPlugin\\Plugin' ) ) {
			$plugin = new Plugin();
			$plugin->init();
		}
	}
);

/* Activation hook - needed for rewrite rules */
register_activation_hook(
	__FILE__,
	static function (): void {
		flush_rewrite_rules();
	}
);

/* Deactivation hook - cleanup rewrite rules */
register_deactivation_hook(
	__FILE__,
	static function (): void {
		flush_rewrite_rules();
	}
);
