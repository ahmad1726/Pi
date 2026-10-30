<?php
include "koneksi.php";
date_default_timezone_set('Asia/Jakarta');
$jam_sekarang = date("H:i");
$manual = $koneksi->query("SELECT * FROM manual WHERE tombol = 1 LIMIT 1");
if($manual->num_rows > 0) {
    $row = $manual->fetch_assoc();
    echo $row['jenis'];
    $koneksi->query("UPDATE manual SET tombol = 0 WHERE jenis = '".$row['jenis']."'");
} 
else {
    $ambil_jadwal = $koneksi->query("SELECT * FROM jadwal WHERE substr(jam, 1, 5) = '$jam_sekarang' AND status = 0 LIMIT 1");
    if($ambil_jadwal->num_rows > 0) {
        $jadwal = $ambil_jadwal->fetch_assoc();
        echo $jadwal['jenis'];
        $koneksi->query("UPDATE jadwal SET status = 1 WHERE id = '".$jadwal['id']."'");
    }
}
$koneksi->query("UPDATE jadwal SET status = 0 WHERE substr(jam, 1, 5) != '$jam_sekarang' AND status = 1");
?>