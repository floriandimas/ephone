<?php

class Database
{

    //Deklarasi Properties untuk konfigurasi database yang digunakan
    private $host = "localhost";
    private $database = "db_hp"; //Sesuaikan nama database Anda
    private $username = "root";
    private $password = "";
    private $conn;

    //Costruktor untuk membuat koneksi dari Class mysqli
    public function __construct()
    {
        //instansiasi objek dari CLASS MYSQLI untuk membuat koneksi
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);
    }

    //method getter untuk mengambil objek koneksi
    public function get_koneksi()
    {
        return $this->conn;
    }

    //method untuk mengecek koneksi ke database
    public function cek_koneksi()
    {
        if ($this->conn->connect_error) {
            die("Koneksi database gagal : " . $this->conn->connect_error);
        } else {
            echo "Koneksi database berhasil !";
        }
    }
}
