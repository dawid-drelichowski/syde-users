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
    <title>Users Directory - <?php bloginfo('name'); ?></title>
    <?php wp_head(); ?>
</head>
<body class="users-table-page">
    <div class="page-container">
        <header class="page-header">
            <h1>Users Directory</h1>
        </header>

        <main class="page-content">
            <?php if (empty($users)): ?>
                <div class="error-message">
                    <h2>No Users Available</h2>
                    <p>Unable to load users from the external API. Please try again later.</p>
                </div>
            <?php else: ?>
                <div class="users-table-container">
                    <table class="users-table">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Username</th>
                                <th>Email</th>
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
                                            <?php echo esc_html($user['name'] ?? 'Unknown'); ?>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="#" class="user-detail-link" data-user-id="<?php echo esc_attr($user['id'] ?? ''); ?>">
                                            <?php echo esc_html($user['username'] ?? 'N/A'); ?>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="#" class="user-detail-link" data-user-id="<?php echo esc_attr($user['id'] ?? ''); ?>">
                                            <?php echo esc_html($user['email'] ?? 'N/A'); ?>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div id="user-details-container" class="user-details-container" style="display: none;">
                    <div class="details-header">
                        <h2>User Details</h2>
                        <button id="close-details" class="close-details" aria-label="Close user details">×</button>
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
                        <h3>Error</h3>
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