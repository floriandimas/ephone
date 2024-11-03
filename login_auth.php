<?php
session_start();
include_once("User.php"); // Pastikan file ini ada dan benar

$user = new User();
if (isset($_POST["btn_login"])) {

    // Mengambil data dari form login
    $username = $_POST["username"];
    $password = $_POST["password"];

    try {
        // Mendapatkan data user berdasarkan username
        $result = $user->get_username($username);

        // Tambahkan pengecekan jika $result adalah false
        if ($result === false) {
            throw new Exception("Query database gagal.");
        }

        if (mysqli_num_rows($result) === 1) {
            $data = mysqli_fetch_assoc($result);

            // Proses untuk mengecek apakah password sesuai dengan hash di database
            if (password_verify($password, $data["password"])) {
                $_SESSION["login"] = true;
                $_SESSION["role"] = $data["role"]; 

                
                if ($data["role"] === "admin") {
                    echo '<script type="text/javascript">';
                    echo 'alert("LOGIN BERHASIL");';
                    echo 'window.location.href = "dashboard.php";'; 
                    echo '</script>';
                } elseif ($data["role"] === "customer") {
                    echo '<script type="text/javascript">';
                    echo 'alert("LOGIN BERHASIL");';
                    echo 'window.location.href = "katalog.php";'; 
                    echo '</script>';
                } else {
                    echo '<script type="text/javascript">';
                    echo 'alert("LOGIN GAGAL: ROLE TIDAK DIKENAL");';
                    echo 'window.location.href = "index.php";';
                    echo '</script>';
                }
            } else {
                // Password tidak sesuai
                echo '<script type="text/javascript">';
                echo 'alert("LOGIN GAGAL: PASSWORD TIDAK SESUAI");';
                echo 'window.location.href = "index.php";';
                echo '</script>';
            }
        } else {
            // Username tidak ditemukan
            echo '<script type="text/javascript">';
            echo 'alert("DATA USER TIDAK DITEMUKAN");';
            echo 'window.location.href = "index.php";';
            echo '</script>';
        }
    } catch (Exception $ex) {
        echo '<script type="text/javascript">';
        echo 'alert("TERJADI ERROR PADA QUERY DATABASE: '.$ex->getMessage().'");';
        echo 'window.location.href = "index.php";';
        echo '</script>';
    }
}
?>
