<?php
include_once("function/Database.php");

class User {

    private $db;
    private $username;

    public function __construct() {
        $this->db = new Database();
    }

    // Fungsi untuk mengambil data user berdasarkan username
    public function get_username($username) {
        $this->username = $this->db->get_koneksi()->real_escape_string($username);

        $query = "SELECT nama, username, password, role
                  FROM data_pengguna
                  WHERE username = '$this->username'";

        $result = mysqli_query($this->db->get_koneksi(), $query);

        // Tambahkan pengecekan jika query gagal
        if (!$result) {
            // Tampilkan pesan error dari mysqli
            die("Error pada query: " . mysqli_error($this->db->get_koneksi()));
        }

        return $result;
    }
}
?>
