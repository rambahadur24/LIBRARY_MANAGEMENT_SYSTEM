<?php
/**
 * Admin User Registration Page
 */

require_once 'config/config.php';

// Redirect if already logged in
if (Security::isLoggedIn()) {
    header('Location: index.php');
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verify CSRF token
    if (!isset($_POST['csrf_token']) || !Security::verifyCSRFToken($_POST['csrf_token'])) {
        $error = 'Invalid security token. Please try again.';
    } else {
        $username = Security::sanitizeInput($_POST['username'] ?? '');
        $email = Security::sanitizeInput($_POST['email'] ?? '');
        $full_name = Security::sanitizeInput($_POST['full_name'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';
        
        // Validation
        $errors = [];
        
        if (empty($username)) {
            $errors[] = 'Username is required.';
        } elseif (strlen($username) < 3) {
            $errors[] = 'Username must be at least 3 characters long.';
        } elseif (!preg_match('/^[a-zA-Z0-9_-]+$/', $username)) {
            $errors[] = 'Username can only contain letters, numbers, underscores, and hyphens.';
        }
        
        if (empty($email)) {
            $errors[] = 'Email is required.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Please enter a valid email address.';
        }
        
        if (empty($full_name)) {
            $errors[] = 'Full name is required.';
        }
        
        if (empty($password)) {
            $errors[] = 'Password is required.';
        } else {
            // Validate password strength
            $passwordErrors = Security::validatePasswordStrength($password);
            $errors = array_merge($errors, $passwordErrors);
        }
        
        if ($password !== $confirm_password) {
            $errors[] = 'Passwords do not match.';
        }
        
        if (!empty($errors)) {
            $error = implode('<br>', $errors);
        } else {
            try {
                $db = Database::getInstance()->getConnection();
                
                // Check if username already exists
                $stmt = $db->prepare("SELECT user_id FROM admin_users WHERE username = :username");
                $stmt->execute([':username' => $username]);
                
                if ($stmt->fetch()) {
                    $error = 'Username already exists. Please choose a different username.';
                } else {
                    // Check if email already exists
                    $stmt = $db->prepare("SELECT user_id FROM admin_users WHERE email = :email");
                    $stmt->execute([':email' => $email]);
                    
                    if ($stmt->fetch()) {
                        $error = 'Email already registered. Please use a different email.';
                    } else {
                        // Hash password and insert new user
                        $password_hash = password_hash($password, PASSWORD_BCRYPT);
                        
                        $stmt = $db->prepare("
                            INSERT INTO admin_users (username, email, password_hash, full_name, role)
                            VALUES (:username, :email, :password_hash, :full_name, 'librarian')
                        ");
                        
                        $stmt->execute([
                            ':username' => $username,
                            ':email' => $email,
                            ':password_hash' => $password_hash,
                            ':full_name' => $full_name
                        ]);
                        
                        $success = 'Registration successful! You can now <a href="login.php">login</a> with your credentials.';
                        
                        // Clear form fields
                        $username = '';
                        $email = '';
                        $full_name = '';
                    }
                }
            } catch (Exception $e) {
                error_log('Registration error: ' . $e->getMessage());
                $error = 'An error occurred during registration. Please try again.';
            }
        }
    }
}

$csrfToken = Security::generateCSRFToken();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - <?php echo APP_NAME; ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .register-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 20px;
        }
        
        .register-box {
            background: white;
            padding: 3rem;
            border-radius: 1rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 450px;
        }
        
        .register-box h1 {
            text-align: center;
            color: #333;
            margin-bottom: 1.5rem;
            font-size: 1.8rem;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: #555;
            font-weight: 500;
        }
        
        .form-group input {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #ddd;
            border-radius: 0.5rem;
            font-size: 1rem;
            transition: border-color 0.3s;
            box-sizing: border-box;
        }
        
        .form-group input:focus {
            outline: none;
            border-color: #667eea;
        }
        
        .btn-register {
            width: 100%;
            padding: 0.75rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 0.5rem;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s;
        }
        
        .btn-register:hover {
            transform: translateY(-2px);
        }
        
        .btn-register:active {
            transform: translateY(0);
        }
        
        .alert {
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
        }
        
        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .login-link {
            text-align: center;
            margin-top: 1.5rem;
            color: #666;
        }
        
        .login-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }
        
        .login-link a:hover {
            text-decoration: underline;
        }
        
        .password-requirements {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 0.5rem;
            padding: 1rem;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            color: #666;
        }
        
        .password-requirements h4 {
            margin-top: 0;
            color: #333;
        }
        
        .password-requirements ul {
            margin: 0.5rem 0;
            padding-left: 1.5rem;
        }
        
        .password-requirements li {
            margin-bottom: 0.25rem;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-box">
            <h1><?php echo APP_NAME; ?></h1>
            
            <?php if (!empty($error)): ?>
                <div class="alert alert-error">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
            
            <?php if (!empty($success)): ?>
                <div class="alert alert-success">
                    <?php echo $success; ?>
                </div>
            <?php endif; ?>
            
            <?php if (empty($success)): ?>
                <form method="POST" action="">
                    <div class="password-requirements">
                        <h4>Password Requirements (REQUIRED):</h4>
                        <ul>
                            <li>✓ At least 6 characters long</li>
                            <li>✓ At least one UPPERCASE letter (A-Z)</li>
                            <li>✓ At least one lowercase letter (a-z)</li>
                            <li>✓ At least one number (0-9)</li>
                            <li>✓ At least one special character (!@#$%^&*()_+-=[]{}|;:,.<>?)</li>
                        </ul>
                    </div>
                    
                    <div class="form-group">
                        <label for="full_name">Full Name *</label>
                        <input 
                            type="text" 
                            id="full_name" 
                            name="full_name" 
                            value="<?php echo htmlspecialchars($full_name ?? ''); ?>"
                            required
                        >
                    </div>
                    
                    <div class="form-group">
                        <label for="username">Username *</label>
                        <input 
                            type="text" 
                            id="username" 
                            name="username" 
                            value="<?php echo htmlspecialchars($username ?? ''); ?>"
                            placeholder="Letters, numbers, dash, underscore only"
                            required
                        >
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email Address *</label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            value="<?php echo htmlspecialchars($email ?? ''); ?>"
                            required
                        >
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Password *</label>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            required
                        >
                    </div>
                    
                    <div class="form-group">
                        <label for="confirm_password">Confirm Password *</label>
                        <input 
                            type="password" 
                            id="confirm_password" 
                            name="confirm_password" 
                            required
                        >
                    </div>
                    
                    <input 
                        type="hidden" 
                        name="csrf_token" 
                        value="<?php echo htmlspecialchars($csrfToken); ?>"
                    >
                    
                    <button type="submit" class="btn-register">Create Account</button>
                </form>
                
                <div class="login-link">
                    Already have an account? <a href="login.php">Login here</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
