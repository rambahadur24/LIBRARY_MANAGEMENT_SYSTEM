# GitHub Push Instructions

## Prerequisites
You need to have Git installed on your system and a GitHub account.

## Step 1: Install Git (if not already installed)
Download from: https://git-scm.com/download/win
Then restart your terminal.

## Step 2: Configure Git (First Time Only)
```cmd
git config --global user.name "rambahadur2452"
git config --global user.email "your-email@example.com"
```

## Step 3: Initialize Git Repository
Navigate to your project directory and run:
```cmd
cd C:\xampp1\htdocs\LIBRARYMANGEMENTSYSTEM
git init
```

## Step 4: Add All Files
```cmd
git add .
```

## Step 5: Create Initial Commit
```cmd
git commit -m "Initial commit: Library Management System with enhanced security

- CSRF token generation on every page load
- XSS protection with input sanitization and output encoding
- SQL injection prevention with prepared statements
- Strong password validation (6+ chars, uppercase, lowercase, numbers, special chars)
- Session timeout and secure authentication
"
```

## Step 6: Create Repository on GitHub
1. Go to https://github.com/new
2. Create a new repository named `library-management-system`
3. Do NOT initialize with README, .gitignore, or license (you'll push existing code)
4. Copy the repository URL (HTTPS or SSH)

## Step 7: Add Remote and Push
Replace `YOUR-USERNAME` and `YOUR-REPO-URL` with your actual values:

### For HTTPS (requires username/password or token):
```cmd
git remote add origin https://github.com/YOUR-USERNAME/library-management-system.git
git branch -M main
git push -u origin main
```

### For SSH (requires SSH key setup):
```cmd
git remote add origin git@github.com:YOUR-USERNAME/library-management-system.git
git branch -M main
git push -u origin main
```

## Step 8: Verify Push
Check your GitHub repository to confirm all files are uploaded.

---

## Summary of Changes Being Pushed:
✅ CSRF Token Generation - New token on every page load
✅ XSS Protection - Input sanitization + output encoding
✅ Strong Password Validation - 6+ characters with uppercase, lowercase, numbers, special characters
✅ Updated registration form with clear password requirements
✅ Security helper functions in config/config.php

## Git Status Check Commands (After Installation):
```cmd
git status              # Check what's changed
git log --oneline       # View commit history
git remote -v           # View remote configuration
```

## Files Modified:
- config/config.php (Added validatePasswordStrength function)
- register.php (Updated password validation, updated UI requirements)
- CSRF_XSS_PROOF.md (New documentation file)

---

**Note**: If you encounter any git errors:
1. Make sure Git is properly installed (`git --version` should show version)
2. Check your internet connection
3. Verify GitHub credentials are correct
4. For SSH errors, set up SSH keys: https://docs.github.com/en/authentication/connecting-to-github-with-ssh
