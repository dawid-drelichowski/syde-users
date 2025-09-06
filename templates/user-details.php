<div class="user-details">
    <h3><?php echo esc_html($user['name'] ?? __('Unknown', SYDE_USERS_TEXTDOMAIN)); ?></h3>
    <div class="user-details-grid">
        <div class="detail-item">
            <strong><?php esc_html_e('Username', SYDE_USERS_TEXTDOMAIN); ?>:</strong>
            <span><?php echo esc_html($user['username'] ?? __('N/A', SYDE_USERS_TEXTDOMAIN)); ?></span>
        </div>
        <div class="detail-item">
            <strong><?php esc_html_e('Email', SYDE_USERS_TEXTDOMAIN) ?>:</strong>
            <span><?php echo esc_html($user['email'] ?? __('N/A', SYDE_USERS_TEXTDOMAIN)); ?></span>
        </div>
        <div class="detail-item">
            <strong><?php esc_html_e('Phone', SYDE_USERS_TEXTDOMAIN) ?>:</strong>
            <span><?php echo esc_html($user['phone'] ?? __('N/A', SYDE_USERS_TEXTDOMAIN)); ?></span>
        </div>
        <div class="detail-item">
            <strong><?php esc_html_e('Website', SYDE_USERS_TEXTDOMAIN) ?>:</strong>
            <span>
                <?php if (!empty($user['website'])): ?>
                    <a href="<?php echo esc_url('http://' . $user['website']); ?>" target="_blank">
                        <?php echo esc_html($user['website']); ?>
                    </a>
                <?php else:
                    esc_html_e('N/A', 'syde-users');
                endif; ?>
            </span>
        </div>
        <?php if (!empty($user['address'])): ?>
        <div class="detail-item">
            <strong><?php esc_html_e('Address', SYDE_USERS_TEXTDOMAIN) ?>:</strong>
            <span>
                <?php 
                $address = $user['address'];
                $addressParts = array_filter([
                    $address['street'] ?? '',
                    $address['suite'] ?? '',
                    $address['city'] ?? '',
                    $address['zipcode'] ?? ''
                ]);
                echo esc_html(implode(', ', $addressParts));
                ?>
            </span>
        </div>
        <?php endif; ?>
        <?php if (!empty($user['company']['name'])): ?>
        <div class="detail-item">
            <strong><?php esc_html_e('Company', SYDE_USERS_TEXTDOMAIN) ?>:</strong>
            <span><?php echo esc_html($user['company']['name']); ?></span>
        </div>
        <?php endif; ?>
    </div>
</div>