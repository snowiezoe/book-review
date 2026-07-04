<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$books = mysqli_query($conn, "SELECT * FROM books WHERE user_id = $user_id ORDER BY created_at DESC");
$total_books = mysqli_num_rows($books);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - BookVerse</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <nav class="navbar">
            <div class="nav-left">
                <h1>📚 BookVerse</h1>
                <span class="welcome">Halo, <?= $_SESSION['user_name'] ?>!</span>
            </div>
            <div class="nav-right">
                <a href="dashboard.php" class="active">Dashboard</a>
                <a href="katalog.php">Katalog</a>
                <a href="tambah.php" class="btn btn-primary btn-small">+ Tambah Buku</a>
                <a href="logout.php" class="btn btn-outline btn-small">Logout</a>
            </div>
        </nav>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">📚</div>
                <div class="stat-info">
                    <h3><?= $total_books ?></h3>
                    <p>Total Buku Anda</p>
                </div>
            </div>
        </div>

        <div class="card" style="padding: 30px;">
            <h2 class="section-title">📖 Koleksi Buku Anda</h2>
            <div class="book-grid">
                <?php if(mysqli_num_rows($books) > 0): ?>
                    <?php while($book = mysqli_fetch_assoc($books)): ?>
                        <div class="book-card">
                            <img src="<?= htmlspecialchars($book['cover']) ?>" alt="<?= htmlspecialchars($book['title']) ?>">
                            <h3><?= htmlspecialchars($book['title']) ?></h3>
                            <p class="author">✍️ <?= htmlspecialchars($book['author']) ?></p>
                            <p class="genre"><?= htmlspecialchars($book['genre']) ?></p>
                            <div class="actions">
                                <a href="detail.php?id=<?= $book['id'] ?>" class="btn btn-primary btn-small">Detail</a>
                                <a href="edit.php?id=<?= $book['id'] ?>" class="btn btn-outline btn-small">Edit</a>
                                <a href="hapus.php?id=<?= $book['id'] ?>" class="btn btn-danger btn-small" onclick="return confirm('Hapus buku ini?')">Hapus</a>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="empty-state">
                        <p>📭 Belum ada buku. <a href="tambah.php">Tambah buku pertama</a></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>