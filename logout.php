<?php
/**
 * Logout Handler - Destroys session and redirects to login
 */

require_once 'config/config.php';

// Destroy session
session_unset();
session_destroy();

// Redirect to login page
header('Location: login.php?logout=1');
exit;
?>
