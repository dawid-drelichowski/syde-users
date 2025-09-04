<div class="user-details">
    <h3><?php echo esc_html($user['name'] ?? 'Unknown'); ?></h3>
    <div class="user-details-grid">
        <div class="detail-item">
            <strong>Username:</strong>
            <span><?php echo esc_html($user['username'] ?? 'N/A'); ?></span>
        </div>
        <div class="detail-item">
            <strong>Email:</strong>
            <span><?php echo esc_html($user['email'] ?? 'N/A'); ?></span>
        </div>
        <div class="detail-item">
            <strong>Phone:</strong>
            <span><?php echo esc_html($user['phone'] ?? 'N/A'); ?></span>
        </div>
        <div class="detail-item">
            <strong>Website:</strong>
            <span>
                <?php if (!empty($user['website'])): ?>
                    <a href="<?php echo esc_url('http://' . $user['website']); ?>" target="_blank">
                        <?php echo esc_html($user['website']); ?>
                    </a>
                <?php else: ?>
                    N/A
                <?php endif; ?>
            </span>
        </div>
        <?php if (!empty($user['address'])): ?>
        <div class="detail-item">
            <strong>Address:</strong>
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
            <strong>Company:</strong>
            <span><?php echo esc_html($user['company']['name']); ?></span>
        </div>
        <?php endif; ?>
    </div>
</div>