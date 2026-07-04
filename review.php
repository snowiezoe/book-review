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
    $book_id = (int)$_POST['book_id'];
    $user_id = $_SESSION['user_id'];
    $rating = (int)$_POST['rating'];
    $comment = mysqli_real_escape_string($conn, $_POST['comment']);
    $reviewer = $_SESSION['user_name'];

    $query = "INSERT INTO reviews (book_id, user_id, rating, comment, reviewer) 
              VALUES ($book_id, $user_id, $rating, '$comment', '$reviewer')";
    mysqli_query($conn, $query);

    $avg = mysqli_fetch_assoc(mysqli_query($conn, "SELECT AVG(rating) as avg_rating FROM reviews WHERE book_id = $book_id"));
    mysqli_query($conn, "UPDATE books SET average_rating = {$avg['avg_rating']} WHERE id = $book_id");

    header("Location: detail.php?id=$book_id");
    exit();
}
?>