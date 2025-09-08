<?php
declare(strict_types=1);

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php esc_html_e('Users List', 'syde-users') ?> - <?php bloginfo('name'); ?></title>
    <?php wp_head(); ?>
</head>
<body class="users-table-page">
    <div class="page-container">
        <header class="page-header">
            <h1><?php esc_html_e('Users List', 'syde-users'); ?></h1>
        </header>

        <main class="page-content">
            <?php if (empty($users)): ?>
                <div class="error-message">
                    <h2><?php esc_html_e('No Users Available', 'syde-users'); ?></h2>
                    <p><?php esc_html_e('Unable to load users from the external API. Please try again later.', 'syde-users'); ?></p>
                </div>
            <?php else: ?>
                <div class="users-table-container">
                    <table class="users-table">
                        <thead>
                            <tr>
                                <th><?php esc_html_e('Id', 'syde-users'); ?></th>
                                <th><?php esc_html_e('Name', 'syde-users'); ?></th>
                                <th><?php esc_html_e('Username', 'syde-users'); ?></th>
                                <th><?php esc_html_e('Email', 'syde-users'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td>
                                        <a href="#" class="user-detail-link" data-user-id="<?php echo esc_attr($user['id'] ?? ''); ?>">
                                            <?php echo esc_html($user['id'] ?? ''); ?>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="#" class="user-detail-link" data-user-id="<?php echo esc_attr($user['id'] ?? ''); ?>">
                                            <?php echo esc_html($user['name'] ?? __('Unknown', 'syde-users')); ?>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="#" class="user-detail-link" data-user-id="<?php echo esc_attr($user['id'] ?? ''); ?>">
                                            <?php echo esc_html($user['username'] ?? __('N/A', 'syde-users')); ?>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="#" class="user-detail-link" data-user-id="<?php echo esc_attr($user['id'] ?? ''); ?>">
                                            <?php echo esc_html($user['email'] ?? __('N/A', 'syde-users')); ?>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div id="user-details-container" class="user-details-container" style="display: none;">
                    <div class="details-header">
                        <h2><?php esc_html_e('User Details', 'syde-users'); ?></h2>
                        <button id="close-details" class="close-details" aria-label="<?php esc_html_e('Close user details', 'syde-users'); ?>">×</button>
                    </div>
                    <div id="user-details-content" class="details-content">
                        <!-- User details will be loaded here via AJAX -->
                    </div>
                </div>

                <div id="loading-spinner" class="loading-spinner" style="display: none;">
                    <div class="spinner"></div>
                </div>

                <div id="error-container" style="display: none;">
                    <div class="error-content">
                        <h3><?php esc_html_e('Error', 'syde-users'); ?></h3>
                        <p data-error-message></p>
                    </div>
                </div>
            <?php endif; ?>
        </main>

        <footer class="page-footer">
            Powered by Syde Users Plugin
        </footer>
    </div>
    <?php wp_footer(); ?>
</body>
</html>