<div class="user-details">
    <h3><?php echo esc_html($user['name'] ?? __('Unknown', 'syde-users')); ?></h3>
    <div class="user-details-grid">
        <div class="detail-item">
            <strong><?php esc_html_e('Username', 'syde-users'); ?>:</strong>
            <span><?php echo esc_html($user['username'] ?? __('N/A', 'syde-users')); ?></span>
        </div>
        <div class="detail-item">
            <strong><?php esc_html_e('Email', 'syde-users') ?>:</strong>
            <span><?php echo esc_html($user['email'] ?? __('N/A', 'syde-users')); ?></span>
        </div>
        <div class="detail-item">
            <strong><?php esc_html_e('Phone', 'syde-users') ?>:</strong>
            <span><?php echo esc_html($user['phone'] ?? __('N/A', 'syde-users')); ?></span>
        </div>
        <div class="detail-item">
            <strong><?php esc_html_e('Website', 'syde-users') ?>:</strong>
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
            <strong><?php esc_html_e('Address', 'syde-users') ?>:</strong>
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
            <strong><?php esc_html_e('Company', 'syde-users') ?>:</strong>
            <span><?php echo esc_html($user['company']['name']); ?></span>
        </div>
        <?php endif; ?>
    </div>
</div>