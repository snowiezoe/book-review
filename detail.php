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

$id = (int)$_GET['id'];

$query = "SELECT books.*, users.name as owner FROM books 
          JOIN users ON books.user_id = users.id 
          WHERE books.id = $id";
$result = mysqli_query($conn, $query);
$book = mysqli_fetch_assoc($result);

if (!$book) {
    die("Buku tidak ditemukan");
}

$reviews = mysqli_query($conn, "SELECT reviews.*, users.name as user_name FROM reviews 
                                JOIN users ON reviews.user_id = users.id 
                                WHERE reviews.book_id = $id ORDER BY reviews.created_at DESC");

$avg = mysqli_fetch_assoc(mysqli_query($conn, "SELECT AVG(rating) as avg_rating FROM reviews WHERE book_id = $id"));
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($book['title']) ?> - BookVerse</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <nav class="navbar">
            <div class="nav-left">
                <h1>📚 BookVerse</h1>
            </div>
            <div class="nav-right">
                <a href="dashboard.php">Dashboard</a>
                <a href="katalog.php">Katalog</a>
                <a href="logout.php" class="btn btn-outline btn-small">Logout</a>
            </div>
        </nav>

        <div class="card detail-container">
            <div class="detail-header">
                <img src="<?= htmlspecialchars($book['cover']) ?>" alt="<?= htmlspecialchars($book['title']) ?>" class="detail-cover">
                <div class="detail-info">
                    <h2><?= htmlspecialchars($book['title']) ?></h2>
                    <p class="author"><strong>Penulis:</strong> <?= htmlspecialchars($book['author']) ?></p>
                    <p><strong>Genre:</strong> <?= htmlspecialchars($book['genre']) ?></p>
                    <p><strong>Tahun:</strong> <?= $book['year'] ?></p>
                    <p><strong>Ditambahkan oleh:</strong> <?= htmlspecialchars($book['owner']) ?></p>
                    <div class="rating-big">
                        ⭐ <?= $avg['avg_rating'] ? number_format($avg['avg_rating'], 1) : '0' ?>
                        (<?= mysqli_num_rows($reviews) ?> review)
                    </div>
                    <p class="synopsis"><?= nl2br(htmlspecialchars($book['synopsis'])) ?></p>
                    
                    <?php if($book['user_id'] == $_SESSION['user_id']): ?>
                        <div class="owner-actions">
                            <a href="edit.php?id=<?= $book['id'] ?>" class="btn btn-primary">✏️ Edit Buku</a>
                            <a href="hapus.php?id=<?= $book['id'] ?>" class="btn btn-danger" onclick="return confirm('Yakin hapus?')">🗑️ Hapus Buku</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="reviews-section">
                <h3>💬 Review Pengguna</h3>
                <?php if($reviews && mysqli_num_rows($reviews) > 0): ?>
                    <?php while($review = mysqli_fetch_assoc($reviews)): ?>
                        <div class="review">
                            <div class="review-header">
                                <strong><?= htmlspecialchars($review['user_name']) ?></strong>
                                <span>⭐ <?= $review['rating'] ?></span>
                            </div>
                            <p><?= htmlspecialchars($review['comment']) ?></p>
                            <small><?= date('d M Y, H:i', strtotime($review['created_at'])) ?></small>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p class="no-review">Belum ada review. Jadilah yang pertama!</p>
                <?php endif; ?>
            </div>

            <div class="review-form">
                <h3>✍️ Beri Review</h3>
                <form action="review.php" method="POST">
                    <input type="hidden" name="book_id" value="<?= $book['id'] ?>">
                    <div class="form-group">
                        <label>Rating</label>
                        <select name="rating" required>
                            <option value="5">⭐⭐⭐⭐⭐ - 5</option>
                            <option value="4">⭐⭐⭐⭐ - 4</option>
                            <option value="3">⭐⭐⭐ - 3</option>
                            <option value="2">⭐⭐ - 2</option>
                            <option value="1">⭐ - 1</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Review</label>
                        <textarea name="comment" placeholder="Tulis review Anda..." rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Kirim Review</button>
                </form>
            </div>
        </div>

        <div class="footer">
            <p>© 2026 BookVerse | Membaca adalah jendela dunia 🌍</p>
        </div>
    </div>
</body>
</html>