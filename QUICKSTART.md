# Quick Start Guide - Library Management System

## Prerequisites
- PHP 7.4+
- MySQL 5.7+
- Apache with mod_rewrite
- Modern web browser

## Installation Steps

### Step 1: Database Setup
```bash
# Login to MySQL
mysql -u root -p

# Create database and import schema
CREATE DATABASE library_management;
USE library_management;
SOURCE database/database.sql;
```

### Step 2: Configure Application
Edit `config/config.php`:
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'your_database_user');
define('DB_PASS', 'your_database_password');
define('DB_NAME', 'library_management');
define('APP_URL', 'http://localhost/library');
```

### Step 3: Deploy Files
Copy all project files to your web server:
```bash
# If using a subdirectory
cp -r library-management-system/* /var/www/html/library/

# Set proper permissions
chmod 755 logs uploads
chmod 644 .htaccess logs/.htaccess uploads/.htaccess
```

### Step 4: Access Application
Open in browser:
```
http://localhost/library/login.php
```

## Default Credentials
- **Username**: admin
- **Password**: admin123

⚠️ **CHANGE PASSWORD IMMEDIATELY AFTER LOGIN!**

## First-Time Setup

### 1. Login
Access the login page and use default credentials

### 2. Change Admin Password
- Navigate to Account Settings (or logout and reset)
- Update password to something secure

### 3. Add Sample Data
Sample books and members are pre-loaded in the database. You can:
- Add more books via `Books > Add New Book`
- Add members via `Members > Add New Member`
- Issue loans via `Loans > Issue New Loan`

## Main Menu Navigation

### Dashboard
- View system statistics
- Quick access to main features

### Books
- **All Books**: View complete book catalog
- **Search**: Advanced search with multiple criteria
- **Add New Book**: Register new book

### Members
- **View Members**: List all library members
- **Add New Member**: Register new member

### Loans
- **Manage Loans**: View all loans and their status
- **Issue New Loan**: Create new book loan
- **Overdue Books**: View and manage overdue loans

## Common Tasks

### Adding a New Book
1. Go to `Books > Add New Book`
2. Fill in required fields:
   - ISBN
   - Title
   - Author
3. Add optional information:
   - Genre, Publisher, Year, Pages
4. Click "Add Book"

### Registering a Member
1. Go to `Members > Add New Member`
2. Fill required fields:
   - First Name
   - Last Name
   - Email
3. Select membership type and click "Add Member"

### Issuing a Loan
1. Go to `Loans > Issue New Loan`
2. Select a book (only available books shown)
3. Select a member (only active members shown)
4. Set loan period (default: 14 days)
5. Click "Issue Loan"

### Returning a Book
1. Go to `Loans > Manage Loans`
2. Find the active loan
3. Click "Return Book"
4. Enter fine if applicable
5. Click "Process Return"

### Checking Overdue Books
1. Go to `Loans > Overdue Books`
2. View all overdue loans
3. Fine is automatically calculated ($0.50/day default)

## Troubleshooting

### Cannot Login
- Verify database is running
- Check MySQL credentials in `config/config.php`
- Check that admin user exists in database

### Database Connection Error
- Verify MySQL is running
- Check database credentials
- Ensure database exists
- Review logs/php_errors.log

### Permission Errors
- Check file permissions: `chmod 755 logs uploads`
- Verify web server user owns the directories
- Check .htaccess syntax

### AJAX Features Not Working
- Verify JavaScript is enabled in browser
- Check browser console for errors
- Verify AJAX files are accessible
- Check file paths in JavaScript

## Security Checklist

- [ ] Change default admin password
- [ ] Update database credentials
- [ ] Set proper file permissions
- [ ] Configure firewall rules
- [ ] Enable HTTPS in production
- [ ] Set secure session timeout
- [ ] Regular backup schedule
- [ ] Monitor error logs

## File Structure Quick Reference

```
library-management-system/
├── config/config.php          # Main configuration
├── models/                     # Data models
├── books/, members/, loans/   # Module pages
├── ajax/                       # AJAX handlers
├── assets/                     # CSS, JS, Images
├── templates/                  # Twig templates
├── database/database.sql      # Database schema
└── README.md                   # Full documentation
```

## Support Resources

- See README.md for full documentation
- Check IMPLEMENTATION_SUMMARY.md for features list
- Review error logs in logs/ directory
- Database schema in database/database.sql

## Performance Tips

1. Regular Database Maintenance
   ```sql
   OPTIMIZE TABLE books, members, loans;
   ```

2. Clear Old Session Files
   - Configure PHP session cleanup
   - Set appropriate session timeout

3. Monitor Error Logs
   - Review logs regularly
   - Address warnings and errors

4. Database Backups
   ```bash
   mysqldump -u user -p library_management > backup.sql
   ```

---

**Last Updated**: December 2025
**Version**: 1.0
**Status**: Production Ready ✅
