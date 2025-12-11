<?php
/**
 * Library Management System - Main Dashboard
 */

require_once 'config/config.php';
require_once 'models/Book.php';

Security::requireLogin();

$bookModel = new Book();

// Get statistics
try {
    $stmt = Database::getInstance()->getConnection()->query("
        SELECT 
            (SELECT COUNT(*) FROM books) as total_books,
            (SELECT SUM(copies_available) FROM books) as available_books,
            (SELECT COUNT(*) FROM members WHERE status = 'active') as active_members,
            (SELECT COUNT(*) FROM loans WHERE status = 'active') as active_loans
    ");
    $stats = $stmt->fetch();
} catch (Exception $e) {
    $stats = ['total_books' => 0, 'available_books' => 0, 'active_members' => 0, 'active_loans' => 0];
}

// Get recent books
$recentBooks = $bookModel->getAll(1, 5);

$pageTitle = 'Dashboard';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle . ' - ' . APP_NAME; ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="container">
        <div class="dashboard">
            <h1>Dashboard</h1>
            
            <!-- Statistics Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">📚</div>
                    <div class="stat-info">
                        <h3><?php echo number_format($stats['total_books']); ?></h3>
                        <p>Total Books</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">✅</div>
                    <div class="stat-info">
                        <h3><?php echo number_format($stats['available_books']); ?></h3>
                        <p>Available Copies</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">👥</div>
                    <div class="stat-info">
                        <h3><?php echo number_format($stats['active_members']); ?></h3>
                        <p>Active Members</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">📖</div>
                    <div class="stat-info">
                        <h3><?php echo number_format($stats['active_loans']); ?></h3>
                        <p>Active Loans</p>
                    </div>
                </div>
            </div>
            
            <!-- Quick Actions -->
            <div class="quick-actions">
                <h2>Quick Actions</h2>
                <div class="action-buttons">
                    <a href="books/search.php" class="btn btn-primary">
                        <span class="btn-icon">🔍</span> Search Books
                    </a>
                    <a href="books/add.php" class="btn btn-success">
                        <span class="btn-icon">➕</span> Add New Book
                    </a>
                    <a href="members/list.php" class="btn btn-info">
                        <span class="btn-icon">👥</span> View Members
                    </a>
                    <a href="loans/list.php" class="btn btn-warning">
                        <span class="btn-icon">📋</span> Manage Loans
                    </a>
                </div>
            </div>
            
            <!-- Recent Books -->
            <div class="recent-books">
                <h2>Recent Books</h2>
                <?php if (!empty($recentBooks)): ?>
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ISBN</th>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Genre</th>
                                <th>Year</th>
                                <th>Available</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recentBooks as $book): ?>
                            <tr>
                                <td><?php echo Security::sanitizeInput($book['isbn']); ?></td>
                                <td><?php echo Security::sanitizeInput($book['title']); ?></td>
                                <td><?php echo Security::sanitizeInput($book['author']); ?></td>
                                <td><?php echo Security::sanitizeInput($book['genre'] ?? 'N/A'); ?></td>
                                <td><?php echo Security::sanitizeInput($book['publication_year'] ?? 'N/A'); ?></td>
                                <td>
                                    <span class="badge <?php echo $book['copies_available'] > 0 ? 'badge-success' : 'badge-danger'; ?>">
                                        <?php echo $book['copies_available']; ?>/<?php echo $book['total_copies']; ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="books/view.php?id=<?php echo $book['book_id']; ?>" class="btn-sm btn-info">View</a>
                                    <a href="books/edit.php?id=<?php echo $book['book_id']; ?>" class="btn-sm btn-primary">Edit</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <p class="no-data">No books found in the system.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <?php include 'includes/footer.php'; ?>
</body>
</html>