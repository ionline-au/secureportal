# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is the ACH Secure Portal - a Laravel 8.x application for secure file exchange between A Counting House (accounting firm) and their clients. The application provides role-based access control, secure file uploads, and comprehensive audit logging.

## Essential Commands

### Development Server
```bash
php artisan serve              # Start Laravel development server (port 8000)
php artisan queue:work         # Process background jobs (required for file processing)
```

### Database
```bash
php artisan migrate            # Run database migrations
php artisan migrate:fresh      # Reset and re-run all migrations (CAUTION: destroys data)
php artisan db:seed           # Seed database with test data
```

### Frontend Assets
```bash
npm run dev                   # Development build
npm run watch                 # Watch for changes and auto-compile
npm run production           # Production build with minification
```

### Testing
```bash
./vendor/bin/phpunit          # Run all PHPUnit tests
./vendor/bin/phpunit --filter TestName  # Run specific test
php artisan dusk             # Run browser tests
```

### Cache Management
```bash
php artisan cache:clear       # Clear application cache
php artisan config:clear      # Clear config cache
php artisan route:clear       # Clear route cache
php artisan view:clear        # Clear compiled views
```

## Architecture Overview

### MVC Structure
- **Controllers**: Organized in `app/Http/Controllers/` with namespaces:
  - `Admin/` - Admin panel functionality (UserController, UploadController, PermissionController)
  - `Frontend/` - Client-facing features (HomeController, ProfileController, UploadController)
  - `Auth/` - Authentication handling
  - `Api/` - API endpoints

- **Models**: Located in `app/Models/` - Core entities include User, Upload, Role, Permission, AuditLog, History

- **Views**: Blade templates in `resources/views/` organized by feature area (admin/, frontend/, auth/)

### Key Architectural Patterns

1. **Authentication & Authorization**
   - Role-based system with Admin and Client roles
   - Custom middleware `IsAdmin` for admin route protection
   - Spatie permissions package integration

2. **File Management**
   - Spatie MediaLibrary for file uploads and storage
   - Custom media collections for organizing uploads
   - Automatic ZIP generation for bulk downloads
   - File download tracking via History model

3. **Data Tables**
   - Server-side processing using Yajra DataTables
   - Custom DataTable classes in `app/DataTables/`
   - AJAX-based data loading for performance

4. **Audit System**
   - Auditable trait applied to models
   - Complete action logging in audit_logs table
   - User activity tracking for compliance

### Database Relationships
- Users → Uploads (one-to-many)
- Users → Roles → Permissions (many-to-many)
- Uploads → Media (via Spatie MediaLibrary)
- All models → AuditLogs (polymorphic)

## Development Guidelines

### Code Conventions
- Follow PSR-4 autoloading standards
- Use Laravel's naming conventions (StudlyCase for classes, camelCase for methods)
- Implement Form Request validation for all user inputs
- Apply Auditable trait to models requiring audit logging

### File Upload Handling
- Files stored in `storage/app/public/` with media library organization
- Validate file types and sizes in Form Requests
- Generate unique file names to prevent conflicts
- Track all downloads in history table

### Frontend Development
- Laravel Mix handles asset compilation (webpack.mix.js)
- SCSS files in `resources/sass/`
- JavaScript in `resources/js/`
- DataTables integration for admin panels

### Testing Approach
- Feature tests for user workflows in `tests/Feature/`
- Unit tests for individual components in `tests/Unit/`
- Browser tests with Laravel Dusk in `tests/Browser/`
- Use factories for test data generation

## Common Development Tasks

### Adding New Admin Panel Feature
1. Create controller in `app/Http/Controllers/Admin/`
2. Add routes in `routes/web.php` within admin middleware group
3. Create DataTable class if listing data
4. Add views in `resources/views/admin/`
5. Update navigation in admin layout

### Implementing File Upload Feature
1. Use MediaUploading trait in controller
2. Configure media collection in model
3. Validate file types in Form Request
4. Track upload in uploads table
5. Log action in audit system

### Creating New User Role
1. Create role via `Role::create(['name' => 'role_name'])`
2. Assign permissions using Spatie methods
3. Update middleware and gates as needed
4. Add role checks in controllers/views

## Environment Configuration

Key environment variables in `.env`:
- `APP_URL` - Application URL (subdomain in production)
- `DB_*` - Database connection settings
- `MAIL_*` - SMTP configuration for notifications
- `BUGSNAG_API_KEY` - Error monitoring service
- `FILESYSTEM_DRIVER` - File storage driver (local/s3)