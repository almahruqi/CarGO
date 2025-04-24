# CarGO - Modern Car Listing Platform

CarGO is a secure and modern car listing platform built with Laravel 10 and Vue.js. It features a robust authentication system, secure file uploads, and real-time notifications.

## Features

### Security
- Secure authentication with Laravel Sanctum
- CSRF protection
- XSS prevention
- SQL injection prevention
- Secure file upload handling
- Rate limiting
- Security headers
- Password hashing with Argon2id
- Email verification
- Two-factor authentication support

### User Features
- User registration and authentication
- Email verification
- Profile management
- Password reset functionality
- Advertisement management
- Image upload with automatic optimization
- Favorite listings
- Real-time notifications
- Advanced search filters

### Admin Features
- User management
- Advertisement moderation
- Analytics dashboard
- System logs
- Backup management

## Requirements

- PHP 8.2+
- MySQL 8.0+
- Redis 6+
- Node.js 18+
- Composer 2+

## Installation

1. Clone the repository:
```bash
git clone https://github.com/yourusername/cargo.git
cd cargo
```

2. Install PHP dependencies:
```bash
composer install --optimize-autoloader --no-dev
```

3. Install Node.js dependencies:
```bash
npm install
```

4. Copy environment file and generate key:
```bash
cp .env.example .env
php artisan key:generate
```

5. Configure your database in `.env`

6. Run migrations:
```bash
php artisan migrate
```

7. Build frontend assets:
```bash
npm run build
```

8. Create storage link:
```bash
php artisan storage:link
```

9. Set proper permissions:
```bash
chmod -R 755 storage bootstrap/cache
```

## Security Best Practices

1. Always keep dependencies up to date:
```bash
composer update
npm update
```

2. Regular security audits:
```bash
composer audit
npm audit
```

3. Enable HTTPS only in production
4. Use strong passwords
5. Keep debug mode disabled in production
6. Regular backups
7. Monitor logs for suspicious activity
8. Keep system and PHP updated
9. Use prepared statements for all database queries
10. Validate all user inputs

## Performance Optimization

1. Enable OPcache
2. Use Redis for caching
3. Queue long-running tasks
4. Optimize images
5. Use CDN for assets
6. Enable compression
7. Cache responses when possible

## Maintenance

1. Regular backups:
```bash
php artisan backup:run
```

2. Clear cache:
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
```

3. Monitor logs:
```bash
tail -f storage/logs/laravel.log
```

## License

MIT License - See LICENSE file for details.

## Support

For support, please open an issue in the GitHub repository.

