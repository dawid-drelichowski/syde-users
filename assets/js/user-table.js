(function($, wp) {
    'use strict';
    const $document = $(document);
    const { __ } = wp.i18n;

    $document.ready(function() {
        const $detailsContainer = $('#user-details-container');
        const $detailsContent = $('#user-details-content');
        const $loadingSpinner = $('#loading-spinner');
        const $errorContainer = $('#error-container');
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
        $closeButton.on('click', () => hideDetailsContainer());

        // ESC key to close details
        $document.on('keydown', (event) => {
            if (event.keyCode === 27) {
                hideDetailsContainer();
            }
        });

        /**
         * Load user details via AJAX
         */
        const loadUserDetails = (userId) => {
            hideError();
            hideDetailsContent();
            showLoadingSpinner();
            showDetailsContainer();

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
                    hideLoadingSpinner();
                    
                    if (response.success && response.data.html) {
                        showDetailsContent(response.data.html);
                    } else {
                        showError(__('Unknown error occurred', 'syde-users'));
                    }
                },
                error: (xhr, status, error) => {
                    hideLoadingSpinner();
                    
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
        const showDetailsContainer = () => {
            if (!$detailsContainer.is(':visible')) {
              $detailsContainer.css('display', 'block')
            };
            
            // Smooth scroll to details
            $('html, body').animate({
                scrollTop: $detailsContainer.offset().top
            }, 600);
        }

        /**
         * Hide user details container
         */
        const hideDetailsContainer = () => {
            if ($detailsContainer.is(':visible')) {
                $detailsContainer.css('display', 'none');
            };
        }

        /**
         * Show user details content
         */
        const showDetailsContent = (content) => {
            $detailsContent.html(content);
            $detailsContent.css('display', 'block');
        }

        /**
         * Hide user details content
         */
        const hideDetailsContent = () => {
            $detailsContent.css('display', 'none');
        }

        const showLoadingSpinner = () => {
            $loadingSpinner.css('display', 'block');
        }

        /**
         * Hide loading spinner
         */
        const hideLoadingSpinner = () => {
            $loadingSpinner.css('display', 'none');
        }

        /**
         * Show error message in details container
         */
        const showError = (message) => {
            $errorContainer.find('[data-error-message]').text(message);
            $errorContainer.css('display', 'block');

            showDetailsContainer();
        }

        /**
         * Hide error message in details container
         */
        const hideError = () => {
            $errorContainer.css('display', 'none');
        }
    });
})(jQuery, wp);
