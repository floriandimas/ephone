<?php
include_once("function/Database.php");
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION["login"]) || $_SESSION["login"] !== true) {
    header("Location: dashboard.php?status=denied");
    exit;
}

class datatoko {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Fungsi untuk mendapatkan semua produk
    public function getProducts() {
        $query = "SELECT * FROM data_toko";
        $result = mysqli_query($this->db->get_koneksi(), $query);

        if (!$result) {
            die("Query gagal: " . mysqli_error($this->db->get_koneksi()));
        }

        return $result;
    }

    // Fungsi untuk pencarian produk berdasarkan keyword
    public function searchProducts($keyword) {
        $query = "SELECT * FROM data_toko WHERE kode LIKE '%$keyword%' OR tipe LIKE '%$keyword%' OR warna LIKE '%$keyword%'";
        $result = mysqli_query($this->db->get_koneksi(), $query);

        if (!$result) {
            die("Query gagal: " . mysqli_error($this->db->get_koneksi()));
        }

        return $result;
    }

    // Fungsi untuk menambah produk
    public function addProduct($kode, $tipe, $kategori, $warna, $memori, $harga, $stok, $gambar) {
        $checkQuery = "SELECT * FROM data_toko WHERE kode='$kode'";
        $checkResult = mysqli_query($this->db->get_koneksi(), $checkQuery);

        if (mysqli_num_rows($checkResult) > 0) {
            return false; // Kode sudah ada
        }

        $query = "INSERT INTO data_toko (kode, tipe, kategori,warna, memori, harga, stok, gambar) VALUES ('$kode','$tipe', '$kategori','$warna','$memori','$harga', '$stok','$gambar')";
        return mysqli_query($this->db->get_koneksi(), $query);
    }

    // Fungsi untuk mengedit produk
    public function editProduct($kode, $tipe, $kategori, $warna, $memori, $harga, $stok) {
        $query = "UPDATE data_toko SET tipe='$tipe', kategori='$kategori', warna='$warna', memori='$memori', harga='$harga', stok='$stok' ,gambar='$gambar' WHERE kode='$kode'";
        return mysqli_query($this->db->get_koneksi(), $query);
    }

    // Fungsi untuk menghapus produk
    public function deleteProduct($kode) {
        $query = "DELETE FROM data_toko WHERE kode='$kode'";
        return mysqli_query($this->db->get_koneksi(), $query);
    }
}

// Menggunakan Kelas datatoko untuk Menangani Aksi Form
$dataToko = new datatoko();

// Cek apakah pencarian dilakukan
$products = null;
if (isset($_POST['search'])) {
    $keyword = $_POST['keyword'];
    $products = $dataToko->searchProducts($keyword);
} else {
    $products = $dataToko->getProducts();
}

// Proses form untuk tambah, edit, atau delete
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['search'])) {
    if (isset($_POST['tambah'])) {
        if (!$dataToko->addProduct($_POST['kode'], $_POST['tipe'],  $_POST['kategori'], $_POST['warna'], $_POST['memori'], $_POST['harga'], $_POST['stok'] ,$_POST['gambar'])) {
            echo "Gagal Tambah Data";
        }
    } elseif (isset($_POST['edit'])) {
        $dataToko->editProduct($_POST['kode'], $_POST['tipe'],  $_POST['kategori'], $_POST['warna'], $_POST['memori'], $_POST['harga'], $_POST['stok'],$_POST['gambar']);
    } elseif (isset($_POST['delete'])) {
        $dataToko->deleteProduct($_POST['kode']);
    }
    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="styledash.css">
    <script>
        function openModal(action, kode = '', tipe = '', kategori = '', warna = '', memori = '', harga = '', stok = '', gambar = '') {
            const modalTitle = document.getElementById('modalTitle');
            const submitButton = document.getElementById('submitButton');
            const actionInput = document.getElementById('actionInput');

            if (action === 'tambah') {
                modalTitle.innerText = 'Tambah Produk';
                submitButton.value = 'Tambah';
                submitButton.name = 'tambah';
            } else if (action === 'edit') {
                modalTitle.innerText = 'Edit Produk';
                submitButton.value = 'Edit';
                submitButton.name = 'edit';
            }

            document.getElementById('kode').value = kode;
            document.getElementById('kode').readOnly = action === 'edit';
            document.getElementById('tipe').value = tipe;
            document.getElementById('kategori').value = kategori;
            document.getElementById('warna').value = warna;
            document.getElementById('memori').value = memori;
            document.getElementById('harga').value = harga;
            document.getElementById('stok').value = stok;
            document.getElementById('gambar').value = gambar;

            document.getElementById('modal').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('modal').style.display = 'none';
        }
    </script>
</head>
<body>
    <div class="sidebar">
        <ul>
            <li><img src="images/basket.png" alt="AVATAR"></li>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="#" onclick="openModal('tambah')">Tambah Produk</a></li>
            <li><a href="index.php">Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <h2>Dashboard Admin</h2>
        <p>Selamat Datang di Dashboard kami! Silakan memilih pekerjaan yang ingin Anda lakukan.</p>
        
        <h3>Data Produk</h3>

        <!-- Search Bar -->
        <form method="POST" action="dashboard.php">
            <input type="text" name="keyword" placeholder="Cari produk..." required>
            <button type="submit" name="search">Cari</button>
        </form>

        <!-- Tabel Data Produk -->
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Tipe</th>
                    <th>kategori</th>
                    <th>Warna</th>
                    <th>Memori</th>
                    <th>Harga</th>
                    <th>Stok</th>

                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                while ($row = mysqli_fetch_assoc($products)) {
                    echo "<tr>
                        <td>{$no}</td>
                        <td>{$row['kode']}</td>
                        <td>{$row['tipe']}</td>
                        <td>{$row['kategori']}</td>
                        <td>{$row['warna']}</td>
                        <td>{$row['memori']}</td>
                        <td>{$row['harga']}</td>
                        <td>{$row['stok']}</td>
                        <td>
                            <a href='#' onclick=\"openModal('edit', '{$row['kode']}', '{$row['tipe']}', '{$row['kategori']}' , '{$row['warna']}', '{$row['memori']}', '{$row['harga']}', '{$row['stok']}' ,'{$row['gambar']}')\" class='btn-edit'>Edit</a>
                            <form style='display:inline;' method='POST' action='dashboard.php'>
                                <input type='hidden' name='kode' value='{$row['kode']}'>
                                <button type='submit' name='delete' class='btn-delete'>Hapus</button>
                            </form>
                        </td>
                    </tr>";
                    $no++;
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Modal untuk Tambah/Edit Produk -->
    <div id="modal" style="display: none;">
        <div>
            <h2 id="modalTitle"></h2>
            <form method="POST" action="dashboard.php">
                <label for="kode">Kode Produk:</label>
                <input type="text" name="kode" id="kode" placeholder="isi dengan kode yang diperlukan!" required>
                <label for="tipe">Nama Produk:</label>
                <input type="text" name="tipe" id="tipe" placeholder="pilih tipe hp yang sesuai!" required>
                <label for="kategori">kategori:</label>
                <input type="text" name="kategori" id="kategori" placeholder="isi dengan kategori yang sesuai!" required>
                <label for="warna">Warna:</label>
                <input type="text" name="warna" id="warna" placeholder="isi dengan warna yang sesuai!" required>
                <label for="memori">Memori:</label>
                <input type="text" name="memori" id="memori" placeholder="tentukan memori yang tersedia!" required>
                <label for="harga">Harga:</label>
                <input type="number" name="harga" id="harga" placeholder="isi dengan harga yang sesuai!" required>
                <label for="stok">Stok:</label>
                <input type="number" name="stok" id="stok" placeholder="isi jumlah stok yang diperlukan!" required>
                <label for="kategori">Lokasi Gambar:</label>
                <input type="text" name="gambar" id="gambar" placeholder="isi informasi lokasi gambar anda! contoh images/defaul.jpg" required>
                <br>
                <input type="submit" id="submitButton">
                <button type="button" onclick="closeModal()">Batal</button>
            </form>
        </div>
    </div>
</body>
</html>
