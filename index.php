<?php
session_start();
if(!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}
include "koneksi.php"; 
?>
<html>
<head>
    <title>Pakan Kucing IoT</title>
    <style>
        body {
            background-image: url('cat4.jpg'); 
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            display: flex; 
            flex-direction: column; 
            align-items: center; 
            font-family: 'Times New Roman', Times, serif;
            padding: 20px;
        }
        .utama {
            width: 100%; 
            max-width: 500px; 
            text-align: center; 
            position: relative;
            background: rgba(255, 255, 255); 
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 4px 5px rgba(0,0,0,0.2);
        }
        table {border-collapse: collapse; width: 100%; margin-top: 20px;}
        th, td {border: 2px solid #000; padding: 10px; text-align: center;}
        th {background-color: #00ccff; color: black;}
        .kotak {background: #ffecf9; padding: 20px; border-radius: 10px; margin-bottom: 15px;}
        .kotak2 {background: #f1ffdb; padding: 20px; border-radius: 10px; margin-bottom: 15px;}
        .tombol-kering {background-color: #ff9800; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px; display: inline-block;}
        .tombol-kering:hover {background-color: #955a01;}
        .tombol-basah {background-color: #00bbff; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px; display: inline-block;}
        .tombol-basah:hover{background-color: #006c93;}
        .tombol-logout {background-color: #ff4d4d; color: white; padding: 8px 15px; text-decoration: none; border-radius: 5px; font-size: 14px; display: inline-block; margin-bottom: 20px;}
        .tombol-logout:hover {background-color: #cc0000;}
        .tombol-hapus {background-color: #ff2828; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px; display: inline-block; font-size: 15px;}
        .tombol-hapus:hover {background-color: #a90000;}
    </style>
</head>
<body>
    <div class="utama"> 
        <div style="text-align: right; width: 100%;">
            <a href="logout.php" class="tombol-logout" onclick="return confirm('Yakin ingin keluar?')">Logout</a>
        </div>
        <h1>Healty Cat, Happy Owner</h1>
        <p>Sayangi kucingmu dengan memberi makanan secara teratur</p>
        <p>Jangan lupa isi kembali makanannya</p>
        <div class="kotak">
            <h3>Tombol Memberi Makan Manual</h3>
            <?php
            $isi_kering = $koneksi->query("SELECT jumlah FROM manual WHERE jenis='kering' LIMIT 1");
            $isi_basah = $koneksi->query("SELECT jumlah FROM manual WHERE jenis='basah' LIMIT 1");
            $kering = $isi_kering ? $isi_kering->fetch_assoc() : null;
            $basah = $isi_basah ? $isi_basah->fetch_assoc() : null;
            $jumlah_kering = $kering ? (int)$kering['jumlah'] : 0;
            $jumlah_basah  = $basah ? (int)$basah['jumlah'] : 0;
            ?>
            <p>Kucing sudah makan dry food sebanyak: <?php echo $jumlah_kering; ?> kali</p>
            <p>Kucing sudah makan wet food sebanyak: <?php echo $jumlah_basah; ?> kali</p>
            <a href="update.php?manual=kering" class="tombol-kering">Beri Pakan Kering</a>
            <a href="update.php?manual=basah" class="tombol-basah">Beri Pakan Basah</a><br><br>
            <a href="update.php?reset=1" onclick="return confirm('Reset total pemberian makan?')">
            <button type="button">Reset</button></a>
        </div>
        <div class="kotak2">
            <h3>Tambah Jadwal Otomatis</h3><br>
            <form action="update.php" method="POST">
                <select name="jenis_pakan">
                <option value="kering">Kering</option>
                <option value="basah">Basah</option>
                </select>
                <input type="time" name="jam_pakan" required>
                <button type="submit" name="tambah_jadwal">Tambah</button>
            </form>
        </div>
        <h3>Daftar Jadwal</h3>
            <table>
                <tr>
                    <th>No</th>
                    <th>Jenis</th>
                    <th>Jam</th>
                    <th>Aksi</th>
                </tr>
                <?php $res = $koneksi->query("SELECT * FROM jadwal ORDER BY jam ASC, jenis ASC");
                    $nomor = 1;
                    if ($res && $res->num_rows > 0) {
                        while($row = $res->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $nomor++; ?></td>
                            <td><?php echo ucwords($row['jenis']); ?></td>
                            <td><?php echo substr($row['jam'], 0, 5); ?></td>
                            <td>
                                <a href="update.php?hapus_id=<?php echo $row['id']; ?>" style="text-decoration: none; color: red;" onclick="return confirm('Hapus jadwal ini?')">Hapus</a>
                            </td>
                        </tr>
                    <?php }
                    } else {echo "<tr><td colspan='4'>Belum ada jadwal.</td></tr>";}
                    ?>
            </table>
            <div style="text-align: right; margin-top: 10px;">
                <div class="tombol-hapus">
                     <a href="update.php?hapus_semua=1" style="color: white; text-decoration: none;" onclick="return confirm('Hapus semua data jadwal?')">Hapus Semua</a>
                </div>
            </div>
    </div>
</body>
</html>