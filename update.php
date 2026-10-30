<?php
include "koneksi.php";

if(isset($_GET['manual'])) {
    $jenis = $_GET['manual'];
    $koneksi->query("UPDATE manual SET tombol = 1 WHERE jenis = '$jenis'");
    $koneksi->query("UPDATE manual SET jumlah = jumlah + 1 WHERE jenis = '$jenis'");
}
if(isset($_POST['tambah_jadwal'])) {
    $jenis = $_POST['jenis_pakan']; 
    $jam = $_POST['jam_pakan'];     
    $koneksi->query("INSERT INTO jadwal (jenis, jam) VALUES ('$jenis', '$jam')");
}
if(isset($_GET['reset'])) {
    $koneksi->query("UPDATE manual SET jumlah = 0");
}
if(isset($_GET['hapus_id'])) {
    $id = $_GET['hapus_id'];
    $koneksi->query("DELETE FROM jadwal WHERE id = '$id'");
}
if(isset($_GET['hapus_semua'])) {
    $koneksi->query("DELETE FROM jadwal");
}
header("Location: index.php");
?>