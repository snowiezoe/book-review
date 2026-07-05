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

$query = "DELETE FROM books WHERE id = $id AND user_id = {$_SESSION['user_id']}";

if (mysqli_query($conn, $query)) {
    header('Location: katalog.php');
} else {
    echo "Gagal menghapus buku : " . mysqli_error($conn);
}
?>