# Library Management System

A comprehensive web-based library management system built with PHP, MySQL, and AJAX. This system provides efficient management of books, members, and book loans.

## Features

- **Book Management**: Add, edit, view, and delete books with detailed information (ISBN, author, genre, etc.)
- **Member Management**: Manage library members with different membership types (student, faculty, public)
- **Loan Management**: Issue and track book loans with automatic fine calculation for overdue books
- **Advanced Search**: Search books by title, author, ISBN, genre, and publication year
- **Autocomplete**: Quick search with AJAX-powered autocomplete suggestions
- **Overdue Report**: View all overdue books with calculated fines
- **Admin Authentication**: Secure login system with role-based access control
- **Responsive Design**: Clean, modern UI that works on desktop and mobile devices
- **Security**: Protection against XSS, SQL injection, and CSRF attacks

## System Requirements

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache web server with .htaccess support
- Composer (optional, for Twig templating)

## Installation

### 1. Database Setup

1. Create a MySQL database named `library_management`
2. Import the SQL schema from `database/database.sql`:
   ```bash
   mysql -u root -p library_management < database/database.sql
   ```

### 2. Configuration

Edit `config/config.php` and update the database credentials:

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'sunshine');
define('DB_NAME', 'library_management');
define('APP_URL', 'http://your-domain/library');
```

### 3. Deploy Files

Copy all project files to your web server's document root or a subdirectory.

### 4. Set Permissions

Ensure proper directory permissions:

```bash
chmod 755 logs
chmod 755 uploads
chmod 644 logs/.htaccess
chmod 644 uploads/.htaccess
```

## Default Admin Account

- **Username**: admin
- **Password**: admin123

⚠️ **IMPORTANT**: Change this password immediately after first login!

## File Structure

```
library-management-system/
├── config/              # Configuration and database setup
├── models/              # Data models (Book, Member, Loan)
├── books/               # Book management pages
├── members/             # Member management pages
├── loans/               # Loan management pages
├── ajax/                # AJAX handlers for dynamic content
├── includes/            # Header and footer templates
├── assets/              # CSS, JavaScript, and images
├── database/            # SQL schema and sample data
├── templates/           # Twig templates (optional)
├── logs/                # Application error logs
└── uploads/             # Book cover images
```

## Usage

### Accessing the System

1. Navigate to `http://your-server/library/login.php`
2. Log in with your admin credentials
3. Use the dashboard to navigate to different sections

### Adding Books

1. Go to Books → Add New Book
2. Enter book details (ISBN, title, author, etc.)
3. Click "Add Book" to save

### Managing Members

1. Go to Members → View Members
2. Click "Add New Member" to register a new member
3. Edit or delete members as needed

### Processing Loans

1. Go to Loans → Issue New Loan
2. Select a book and member
3. Set the loan period (default: 14 days)
4. Click "Issue Loan"

### Returning Books

1. Go to Loans → View Loans
2. Find the active loan
3. Click "Return Book"
4. Enter any fine amount if applicable
5. Process the return

### Viewing Overdue Books

1. Go to Loans → Overdue Books
2. View all overdue loans with calculated fines
3. Process returns directly from this page

## Security Features

- **CSRF Protection**: All forms include CSRF tokens
- **XSS Prevention**: All user input is sanitized
- **SQL Injection Prevention**: Prepared statements for all database queries
- **Password Security**: Passwords are hashed using bcrypt
- **Session Security**: Secure session configuration and timeout
- **File Upload Security**: Restricted file uploads to safe directory

## API Endpoints

### AJAX Handlers

- `ajax/autocomplete.php` - Get autocomplete suggestions
- `ajax/check_isbn.php` - Validate ISBN availability
- `ajax/get_member_info.php` - Fetch member information

## Troubleshooting

### Database Connection Issues

- Verify MySQL is running
- Check credentials in `config/config.php`
- Ensure database exists and is accessible

### Permission Errors

- Check file and directory permissions
- Ensure logs/ and uploads/ directories are writable
- Verify .htaccess files are in place

### Login Issues

- Clear browser cookies and cache
- Verify admin user exists in database
- Check PHP session configuration

## Support

For issues and questions:
- Check the application error logs in `logs/` directory
- Review database schema in `database/database.sql`
- Consult inline code comments

## License

This project is provided as-is for educational purposes.

## Authors

Library Management System Development Team

---

**Last Updated**: December 2025
