// create 
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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $author = mysqli_real_escape_string($conn, $_POST['author']);
    $genre = mysqli_real_escape_string($conn, $_POST['genre']);
    $synopsis = mysqli_real_escape_string($conn, $_POST['synopsis']);
    $year = (int)$_POST['year'];
    $cover = mysqli_real_escape_string($conn, $_POST['cover']);

    $query = "INSERT INTO books (user_id, title, author, genre, synopsis, year, cover) 
              VALUES ($user_id, '$title', '$author', '$genre', '$synopsis', $year, '$cover')";
    
    if (mysqli_query($conn, $query)) {
        header('Location: katalog.php');
        exit();
    } else {
        $error = "Gagal menambahkan buku: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Buku - BookVerse</title>
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

        <div class="card" style="padding: 35px; max-width: 600px; margin: 0 auto;">
            <h2 class="section-title">📖 Tambah Buku Baru</h2>
            
            <?php if(isset($error)): ?>
                <div class="alert error">❌ <?= $error ?></div>
            <?php endif; ?>

            <form action="" method="POST">
                <div class="form-group">
                    <label>Judul Buku *</label>
                    <input type="text" name="title" placeholder="Masukkan judul buku" required>
                </div>
                
                <div class="form-group">
                    <label>Penulis *</label>
                    <input type="text" name="author" placeholder="Masukkan nama penulis" required>
                </div>
                
                <div class="form-group">
                    <label>Genre *</label>
                    <input type="text" name="genre" placeholder="Contoh: Fantasy, Romance" required>
                </div>
                
                <div class="form-group">
                    <label>Sinopsis *</label>
                    <textarea name="synopsis" rows="5" placeholder="Tulis sinopsis buku" required></textarea>
                </div>
                
                <div class="form-group">
                    <label>Tahun Terbit *</label>
                    <input type="number" name="year" placeholder="Contoh: 2024" required>
                </div>
                
                <div class="form-group">
                    <label>URL Cover</label>
                    <input type="text" name="cover" placeholder="https://example.com/cover.jpg">
                    <small>Kosongkan untuk menggunakan gambar default</small>
                </div>
                
                <button type="submit" class="btn btn-primary btn-block">Simpan Buku</button>
                <a href="katalog.php" class="btn btn-outline btn-block" style="text-align: center; margin-top: 10px;">Batal</a>
            </form>
        </div>

        <div class="footer">
            <p>© 2026 BookVerse | Membaca adalah jendela dunia 🌍</p>
        </div>
    </div>
</body>
</html>