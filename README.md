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

**For Pretty Permalinks:**
```
https://your-site.com/syde-users/
```
**For Plain Permalinks:**
```
https://your-site.com/?syde_users=1
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

**The plugin implements server-side caching using WordPress Transients:**

#### WordPress Transients Choice
**WordPress Transients were selected over other caching solutions for several reasons:**
- **Native WordPress Integration**: Transients are built into WordPress core, ensuring compatibility across all WordPress installations without external dependencies
- **Expiration Handling**: Built-in TTL (Time To Live) management with automatic cleanup of expired data
- **Network-Aware**: In multisite installations, transients respect network/site boundaries appropriately
- **Plugin Deactivation Cleanup**: Transients can be easily cleaned up when plugin is deactivated, preventing orphaned cache entries
- **No External Service Dependencies**: Works out-of-the-box on any WordPress hosting environment without requiring Redis, Memcached, or file system write permissions
- **WordPress Standards Compliance**: Following WordPress best practices for plugin development

#### Cache Implementation
- **User List Cache**: WordPress transients for users table data (1 hour TTL)
- **User Details Cache**: Individual user details cached via transients (1 hour TTL)

**How Transients Work:**
- **Database Storage**: By default, transients are stored in WordPress database with automatic expiration
- **Object Cache Integration**: When persistent object cache (Redis/Memcached) is available, transients automatically leverage it for better performance
- **Automatic Cleanup**: Expired transients are automatically removed, preventing database bloat

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
composer cs               # Check code standards
composer cs-fix           # Fix code standards
```

## Testing

### Unit Tests

The plugin includes comprehensive unit tests using:
- **PHPUnit**: Testing framework
- **Brain Monkey**: WordPress function mocking

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
- `dealerdirect/phpcodesniffer-composer-installer`: Automatic CS installation
- `syde/phpcs`: Coding standards for Syde WordPress projects

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
- **JavaScript**: ES5 compatible
- **CSS**: Cross-browser compatible, responsive

## Error Scenarios Handled

1. **API Unavailable**: Displays cached data or error message
2. **Invalid JSON Response**: Shows user-friendly error
3. **Network Timeouts**: Implements retry logic with exponential backoff
4. **Cache Failures**: Falls back to direct API calls

## Future Enhancements

Potential improvements (not implemented to maintain focus):
- Admin settings page for endpoint customization
- Template override support in themes
- REST API endpoints for external integration
- Pagination for large user lists
- Advanced filtering and sorting options
- Assets minification
- E2E tests

## Troubleshooting

### Common Issues

**Plugin Activation Fails**
- Check PHP version (8.0+ required)
- Verify Composer dependencies installed
- Check error logs for specific issues

**Custom Endpoint Not Working**
- **For Pretty Permalinks**: Flush rewrite rules (Settings → Permalinks → Save)
- **For Plain Permalinks**: Use `?syde_users=1` query parameter format
- Check .htaccess file permissions
- **Verify permalink structure - plugin works with both Pretty and Plain permalinks**

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
