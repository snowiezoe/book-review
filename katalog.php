<?php
session_start();

$host = 'localhost';
$username = 'root';
$password = '';
$database = 'BookVerse';

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$query = "SELECT books.*, users.name as owner,
          (SELECT AVG(rating) FROM reviews WHERE book_id = books.id) as average_rating
          FROM books 
          JOIN users ON books.user_id = users.id 
          ORDER BY books.created_at DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Buku - BookVerse</title>
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
                <a href="dashboard.php">Dashboard</a>
                <a href="katalog.php" class="active">Katalog</a>
                <a href="tambah.php" class="btn btn-primary btn-small">+ Tambah Buku</a>
                <a href="logout.php" class="btn btn-outline btn-small">Logout</a>
            </div>
        </nav>

        <div class="card" style="padding: 30px;">
            <h2 class="section-title">📚 Semua Buku</h2>
            <p class="section-text" style="margin-bottom: 20px;">Temukan dan kelola koleksi buku favorit Anda</p>
            
            <div class="book-grid">
                <?php if($result && mysqli_num_rows($result) > 0): ?>
                    <?php while($book = mysqli_fetch_assoc($result)): ?>
                        <div class="book-card">
                            <img src="<?= htmlspecialchars($book['cover']) ?>" alt="<?= htmlspecialchars($book['title']) ?>">
                            <h3><?= htmlspecialchars($book['title']) ?></h3>
                            <p class="author">✍️ <?= htmlspecialchars($book['author']) ?></p>
                            <p class="genre"><?= htmlspecialchars($book['genre']) ?></p>
                            <p class="owner">👤 <?= htmlspecialchars($book['owner']) ?></p>
                            <div class="rating">⭐ <?= $book['average_rating'] ? number_format($book['average_rating'], 1) : '0' ?></div>
                            <div class="actions">
                                <a href="detail.php?id=<?= $book['id'] ?>" class="btn btn-primary btn-small">Detail</a>
                                <?php if($book['user_id'] == $_SESSION['user_id']): ?>
                                    <a href="edit.php?id=<?= $book['id'] ?>" class="btn btn-outline btn-small">Edit</a>
                                    <a href="hapus.php?id=<?= $book['id'] ?>" class="btn btn-danger btn-small" onclick="return confirm('Yakin ingin menghapus buku ini?')">Hapus</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="empty-state" style="grid-column: 1 / -1;">
                        <p>📭 Belum ada buku dalam katalog.</p>
                        <a href="tambah.php" class="btn btn-primary">Tambah Buku Pertama</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="footer">
            <p>© 2026 BookVerse | Membaca adalah jendela dunia 🌍</p>
        </div>
    </div>
</body>
</html>