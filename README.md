# Syde WordPress Engineer Task

## Overview

This WordPress plugin was developed as part of the recruitment process for Syde. It demonstrates a complete implementation of the take-home task requirements, showcasing modern WordPress development practices, object-oriented PHP architecture, and adherence to Syde coding standards.

## Project Description

The plugin creates a custom endpoint that displays an HTML table listing users fetched from the JSONPlaceholder API. Each user row contains clickable links that asynchronously load detailed user information without page reload. All HTTP requests are handled server-side with appropriate caching and error handling mechanisms.

## Key Features

- ✅ Custom WordPress endpoint (`/syde-users/`)
- ✅ Server-side API integration with JSONPlaceholder
- ✅ HTML table displaying users (Id, name, username, email)
- ✅ AJAX-powered user detail loading
- ✅ Server-side HTTP request caching
- ✅ Comprehensive error handling
- ✅ Object-oriented PHP architecture (PHP 8.0+)
- ✅ Full Composer support and autoloading
- ✅ Unit tests with Brain Monkey
- ✅ PHPCS compliance with Syde coding standards
- ✅ Extensible via WordPress hooks and filters

## System Requirements

- **WordPress**: 6.0 or higher (latest version targeted)
- **PHP**: 8.0 or higher
- **Composer**: 2.0 or higher
- **MySQL**: 5.7 or higher

## Installation

### Quick Setup

1. Clone the repository:
   ```bash
   git clone https://github.com/dawid-drelichowski/syde-users syde-users
   cd syde-users
   ```

2. Install dependencies:
   ```bash
   composer install
   ```

3. Upload to WordPress plugins directory or install via WordPress admin

4. Activate the plugin through WordPress admin panel

## Usage

Once activated, visit the custom endpoint:
```
https://your-site.com/syde-users/
```

The page will display:
- HTML table with users from JSONPlaceholder API
- Clickable user Id, name, and username links
- User details section that updates via AJAX when links are clicked

## Architecture & Implementation Decisions

### Custom Endpoint Implementation

The plugin uses WordPress rewrite rules to create a custom endpoint rather than relying on existing post/page structures. This approach:
- Maintains clean URLs without query parameters
- Integrates properly with WordPress routing system
- Allows for future extensibility

### Server-Side HTTP Requests

All API requests are handled server-side as specifically required. This design choice:
- Centralizes API communication logic
- Enables server-side caching implementation
- Maintains consistent error handling

### Caching Strategy

The plugin implements a two-tier caching system:
- **Transient Cache**: WordPress transients for user list (15 minutes TTL)
- **Object Cache**: Individual user details caching (30 minutes TTL)

This approach balances data freshness with performance while reducing external API calls.

### Error Handling

Comprehensive error handling includes:
- HTTP request failures with graceful degradation
- JSON parsing errors
- Cache failures with fallback mechanisms
- User-friendly error messages in frontend

### AJAX Implementation

User detail loading uses WordPress's built-in AJAX system:
- Proper nonce verification for security
- Structured JSON responses
- Loading states and error feedback
- Progressive enhancement approach

## Development

### Code Standards

The plugin follows Syde coding standards:
- PSR-4 autoloading
- Object-oriented design patterns
- WordPress coding standards
- PHPCS configuration for automated checking

### Available Composer Scripts

```bash
composer install          # Install dependencies
composer test             # Run PHPUnit tests
composer phpcs            # Check code standards
composer phpcbf           # Fix code standards
composer autoload-dump    # Regenerate autoloader
```

## Testing

### Unit Tests

The plugin includes comprehensive unit tests using:
- **PHPUnit**: Testing framework
- **Brain Monkey**: WordPress function mocking
- **Mockery**: Object mocking

Test coverage includes:
- API client functionality
- Cache management
- Endpoint routing
- AJAX handlers
- Template rendering

Tests run independently without WordPress or external API dependencies.

## Composer Dependencies

### Production Dependencies

- **Minimal external dependencies** following Syde preferences
- Dependencies justified by significant functionality benefits

### Development Dependencies

- `phpunit/phpunit`: Unit testing framework
- `brain/monkey`: WordPress testing utilities  
- `squizlabs/php_codesniffer`: Code style checking
- `wp-coding-standards/wpcs`: WordPress coding standards
- `dealerdirect/phpcodesniffer-composer-installer`: Automatic CS installation

## Security Considerations

- **Output Escaping**: All output properly escaped
- **Nonce Verification**: AJAX requests protected with WordPress nonces
- **Capability Checks**: Admin functions protected by appropriate capabilities
- **SQL Injection Prevention**: No direct database queries, using WordPress APIs

## Performance Optimizations

- **Caching Layer**: Reduces external API calls
- **Lazy Loading**: User details loaded on demand

## Browser Compatibility

- **Modern Browsers**: Chrome, Firefox, Safari, Edge (last 2 versions)
- **JavaScript**: ES5 compatible with progressive enhancement
- **CSS**: Cross-browser compatible with graceful degradation

## Error Scenarios Handled

1. **API Unavailable**: Displays cached data or error message
2. **Invalid JSON Response**: Shows user-friendly error
3. **Network Timeouts**: Implements retry logic with exponential backoff
4. **Cache Failures**: Falls back to direct API calls
5. **JavaScript Disabled**: Basic functionality remains available

## Future Enhancements

Potential improvements (not implemented to maintain focus):
- Admin settings page for endpoint customization
- Template override support in themes
- REST API endpoints for external integration
- Pagination for large user lists
- Advanced filtering and sorting options
- Assets minification

## Troubleshooting

### Common Issues

**Plugin Activation Fails**
- Check PHP version (8.0+ required)
- Verify Composer dependencies installed
- Check error logs for specific issues

**Custom Endpoint Not Working**
- Flush rewrite rules (Settings → Permalinks → Save)
- Check .htaccess file permissions
- Verify permalink structure is not "Plain"

**API Requests Failing**
- Check server's outbound HTTP capabilities
- Test JSONPlaceholder API availability

### Debug Mode

Enable WordPress debug mode for detailed error information:
```php
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
```

## Implementation Notes

This plugin was specifically designed to meet all mandatory requirements of the Syde take-home task:

- ✅ Custom endpoint implementation
- ✅ Server-side HTTP requests only
- ✅ AJAX user detail loading  
- ✅ Server-side caching
- ✅ Comprehensive error handling
- ✅ Object-oriented PHP 8.0+
- ✅ Full Composer support
- ✅ Unit tests with Brain Monkey
- ✅ PHPCS compliance
- ✅ WordPress native functionality usage
- ✅ Complete documentation

The focus remained on backend excellence while providing a functional, well-tested solution that demonstrates professional WordPress development practices.

---

**Contact**: [Dawid Drelichowski](mailto:dawid.drelichowski@gmail.com)  
**Developed for**: Syde GmbH Recruitment Process  
