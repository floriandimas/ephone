<?php
include_once("function/Database.php");
session_start();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password for security

    // Check if the username already exists
    $db = new Database();
    $connection = $db->get_koneksi();
    $checkQuery = "SELECT * FROM data_pengguna WHERE username='$username'";
    $checkResult = mysqli_query($connection, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        echo "<script>alert('Username sudah digunakan!');</script>";
    } else {
        // Insert new user into the database
        $query = "INSERT INTO data_pengguna (username, password) VALUES ('$username', '$password')";
        if (mysqli_query($connection, $query)) {
            echo "<script>alert('Registrasi berhasil! Silakan Verivikasi ke Admin Databasenya!.'); window.location.href='index.php';</script>";
        } else {
            echo "<script>alert('Registrasi gagal!');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun</title>
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="daftar.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Daftar Akun Baru</h2>
        <form action="daftar.php" method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Daftar</button>
            <p class="mt-3">Sudah punya akun? <a href="index.php">Login di sini</a>.</p>
        </form>
    </div>
</body>
</html>
