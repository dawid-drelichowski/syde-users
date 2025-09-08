(function($, wp) {
    'use strict';
    const detailsContainerFadeDuration = 400; // in ms
    const $document = $(document);
    const { __ } = wp.i18n;

    $document.ready(function() {
        const $detailsContainer = $('#user-details-container');
        const $detailsContent = $('#user-details-content');
        const $loadingSpinner = $('#loading-spinner');
        const $closeButton = $('#close-details');

        // Handle user detail link clicks
        $('[data-user-id]').on('click', (event) => {
            event.preventDefault();
            
            const userId = $(event.target).data('user-id');
            if (!userId) {
                showError(__('No user Id found'));
                return;
            }

            loadUserDetails(userId);
        });

        // Handle close button
        $closeButton.on('click', () => hideUserDetails());

        // ESC key to close details
        $document.on('keydown', (event) => {
            if (event.keyCode === 27 && $detailsContainer.is(':visible')) {
                hideUserDetails();
            }
        });

        // Click outside to close
        $document.on('click', (event) => {
            if ($detailsContainer.is(':visible') && 
                !$detailsContainer.is(event.target) && 
                $detailsContainer.has(event.target).length === 0) {
                hideUserDetails();
            }
        });

        /**
         * Load user details via AJAX
         */
        const loadUserDetails = (userId) => {
            // Show loading spinner
            hideUserDetails(true);
            $loadingSpinner.fadeIn(detailsContainerFadeDuration);


            $.ajax({
                url: sydeUsersAjax.ajax_url,
                type: 'POST',
                data: {
                    action: 'get_user_details',
                    user_id: userId,
                    nonce: sydeUsersAjax.nonce
                },
                timeout: 15000, // 15 second timeout
                success: (response) => {
                    $loadingSpinner.hide();
                    
                    if (response.success && response.data.html) {
                        $detailsContent.html(response.data.html);
                        showUserDetails();
                    } else {
                        showError(__('Unknown error occurred', 'syde-users'));
                    }
                },
                error: (xhr, status, error) => {
                    $loadingSpinner.hide();
                    
                    let message = __('Network error occurred. Please try again.', 'syde-users');
                    
                    if (status === 'timeout') {
                        message = __('Request timed out. Please check your connection and try again.', 'syde-users');
                    } else if (xhr.status === 0) {
                        message = __('No connection. Please check your internet connection.', 'syde-users');
                    } else if (xhr.status >= 500) {
                        message = __('Server error occurred. Please try again later.', 'syde-users');
                    }
                    
                    console.error('AJAX error:', status, error, xhr);
                    showError(message);
                }
            });
        }

        /**
         * Show user details container with animation
         */
        const showUserDetails = () => {
            $detailsContainer.fadeIn(detailsContainerFadeDuration);
            
            // Smooth scroll to details
            $('html, body').animate({
                scrollTop: $detailsContainer.offset().top
            }, 600);
        }

        /**
         * Hide user details container
         */
        const hideUserDetails = (immediately = false) => {
            $detailsContainer.fadeOut(immediately ? 0 : detailsContainerFadeDuration);
        }

        /**
         * Show error message in details container
         */
        const showError = (message) => {
            const $errorContent = $('#error-container').contents().clone();
            $errorContent.find('[data-error-message]').text(message).removeAttr('data-error-message');

            $detailsContent.html($errorContent);
            showUserDetails();
        }
    });
})(jQuery, wp);
