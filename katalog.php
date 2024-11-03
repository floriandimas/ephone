<?php
include_once("function/Database.php");
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION["login"]) || $_SESSION["login"] !== true) {
    header("Location: katalog.php?status=denied");
    exit;
}

class datatoko {
    private $db;

    public function __construct() {
        $this->db = new database();    
    }

    public function getProduct(){
        $query = "SELECT tipe, warna, memori, harga, stok, gambar FROM data_toko";
        $result = mysqli_query($this->db->get_koneksi(), $query);

        if (!$result) {
            die("Query Gagal: " . mysqli_error($this->db->get_koneksi()));
        }

        return $result;
    }

    public function searchProduct($keyword) {
        $query = "SELECT * FROM data_toko WHERE kode LIKE '%$keyword%' OR tipe LIKE '%$keyword%' OR warna LIKE '%$keyword%'";
        $result = mysqli_query($this->db->get_koneksi(), $query);
    
        if (!$result) {
            die("Query gagal: " . mysqli_error($this->db->get_koneksi()));
        }
    
        return $result;
    }
}

$datatoko = new datatoko();

$products = null;
if (isset($_POST['search'])) {
    $keyword = $_POST['keyword'];
    $products = $datatoko->searchProduct($keyword);
} else {
    $products = $datatoko->getProduct();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Shop</title>
    <link rel="stylesheet" href="stylekata.css">
</head>
<body>
    <nav class="navbar">
        <div class="navbarlogo"></div>
        <img src="images/basket.png" alt="AVATAR">
        <h1><a href="katalog.php">ephone</a></h1>
        <!-- Search Bar -->
        <form method="POST" action="katalog.php">
            <input type="text" name="keyword" placeholder="Cari produk..." required>
            <button type="submit" name="search">Cari</button>
        </form>
        <a href="index.php">Logout</a>
    </nav>

    <div class="main">
        <table>
            <tr>
                <h2>Kategori Pilihan</h2>
            </tr>
        </table> 
        <div class="product-grid">
            <?php
                // Check if there are products
                if (mysqli_num_rows($products) > 0) {
                    while ($row = mysqli_fetch_assoc($products)) {
                        $imagePath = !empty($row['gambar']) ? $row['gambar'] : "images/default.jpg";
                        echo "<div class='product-card'>";
                        echo "<img src='$imagePath' alt='{$row['tipe']}' class='product-img'>";
                        echo "<div class='product-details'>";
                        echo "<p>{$row['tipe']}</p>";
                        echo "<p>Color: {$row['warna']}</p>";
                        echo "<p>Memory: {$row['memori']}</p>";
                        echo "<p class='price'>Rp " . number_format($row['harga'], 0, ',', '.') . "</p>";
                        echo "<p>Stock: {$row['stok']}</p>";
                        echo "</div>";
                        echo "</div>";
                    }
                } else {
                    echo "<p>No products found.</p>";
                }
            ?>
        </div>
    </div>
</body>
</html>
