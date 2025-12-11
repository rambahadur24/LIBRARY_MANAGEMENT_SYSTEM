<?php
/**
 * Login Page - Authentication
 */

require_once 'config/config.php';

// Redirect if already logged in
if (Security::isLoggedIn()) {
    header('Location: index.php');
    exit;
}

$error = '';
$timeout = isset($_GET['timeout']) ? true : false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verify CSRF token
    if (!isset($_POST['csrf_token']) || !Security::verifyCSRFToken($_POST['csrf_token'])) {
        $error = 'Invalid security token. Please try again.';
    } else {
        $username = Security::sanitizeInput($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        
        if (empty($username) || empty($password)) {
            $error = 'Please enter both username and password.';
        } else {
            try {
                $db = Database::getInstance()->getConnection();
                $stmt = $db->prepare("SELECT * FROM admin_users WHERE username = :username");
                $stmt->execute([':username' => $username]);
                $user = $stmt->fetch();
                
                if ($user && Security::verifyPassword($password, $user['password_hash'])) {
                    // Login successful
                    $_SESSION['user_id'] = $user['user_id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['full_name'] = $user['full_name'];
                    $_SESSION['role'] = $user['role'];
                    $_SESSION['last_activity'] = time();
                    
                    // Update last login
                    $stmt = $db->prepare("UPDATE admin_users SET last_login = NOW() WHERE user_id = :id");
                    $stmt->execute([':id' => $user['user_id']]);
                    
                    header('Location: index.php');
                    exit;
                } else {
                    $error = 'Invalid username or password.';
                }
            } catch (Exception $e) {
                error_log('Login error: ' . $e->getMessage());
                $error = 'An error occurred. Please try again.';
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
    <title>Login - <?php echo APP_NAME; ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .login-box {
            background: white;
            padding: 3rem;
            border-radius: 1rem;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            max-width: 400px;
            width: 100%;
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .login-header h1 {
            color: var(--primary-color);
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }
        
        .login-header p {
            color: var(--text-secondary);
        }
        
        .login-form .form-group {
            margin-bottom: 1.5rem;
        }
        
        .login-btn {
            width: 100%;
            padding: 1rem;
            font-size: 1.1rem;
        }
        
        .demo-credentials {
            margin-top: 1.5rem;
            padding: 1rem;
            background: var(--light-bg);
            border-radius: var(--radius);
            font-size: 0.875rem;
        }
        
        .demo-credentials strong {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--primary-color);
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <div class="login-header">
                <h1>📚 Library System</h1>
                <p>Please login to continue</p>
            </div>
            
            <?php if ($timeout): ?>
            <div class="alert alert-info">
                Your session has expired. Please login again.
            </div>
            <?php endif; ?>
            
            <?php if ($error): ?>
            <div class="alert alert-danger">
                <?php echo htmlspecialchars($error); ?>
            </div>
            <?php endif; ?>
            
            <form method="POST" action="" class="login-form">
                <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" 
                           id="username" 
                           name="username" 
                           class="form-control" 
                           required 
                           autofocus
                           value="<?php echo htmlspecialchars($username ?? ''); ?>">
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" 
                           id="password" 
                           name="password" 
                           class="form-control" 
                           required>
                </div>
                
                <button type="submit" class="btn btn-primary login-btn">
                    Login
                </button>
            </form>
            
            <div class="demo-credentials">
                <strong>Demo Credentials:</strong>
                Username: admin<br>
                Password: admin123
            </div>
            
            <div style="text-align: center; margin-top: 1.5rem; color: #666;">
                Don't have an account? <a href="register.php" style="color: #667eea; text-decoration: none; font-weight: 600;">Register here</a>
            </div>
        </div>
    </div>
</body>
</html>