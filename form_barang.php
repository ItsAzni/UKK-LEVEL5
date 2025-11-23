<?php

include 'fungsi.php';

// Cek login
requireLogin();

$id = $_GET['id'] ?? null;
$data = null;

// Jika ada ID, ambil data barang untuk diedit
if ($id) {
    $data = $koneksi->query("SELECT * FROM barang WHERE id = $id")->fetch_assoc();
}

// Proses simpan data (Tambah/Edit)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $deskripsi = $_POST['deskripsi'];
    $jumlah = $_POST['jumlah'];
    $jumlah_tersedia = $_POST['jumlah_tersedia'];
    $lokasi = $_POST['lokasi'];
    $kode = $_POST['kode'];

    if ($id && $data) {
        // Update data barang
        $stmt = $koneksi->prepare("UPDATE barang SET nama=?, deskripsi=?, jumlah=?, jumlah_tersedia=?, lokasi=?, kode=? WHERE id=?");
        $stmt->bind_param("ssiissi", $nama, $deskripsi, $jumlah, $jumlah_tersedia, $lokasi, $kode, $id);
    } else {
        // Insert data barang baru
        $stmt = $koneksi->prepare("INSERT INTO barang (nama, deskripsi, jumlah, jumlah_tersedia, lokasi, kode) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiiss", $nama, $deskripsi, $jumlah, $jumlah_tersedia, $lokasi, $kode);
    }

    $stmt->execute();
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Form Barang</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div>
        <h2><?= $id ? 'Edit' : 'Tambah' ?> Barang</h2>
        <form method="post">
            <label>Nama Barang</label>
            <input type="text" name="nama" value="<?= $data['nama'] ?? '' ?>" required>

            <label>Deskripsi</label>
            <textarea name="deskripsi" required><?= $data['deskripsi'] ?? '' ?></textarea>

            <label>Jumlah Total</label>
            <input type="number" name="jumlah" value="<?= $data['jumlah'] ?? '' ?>" required>

            <label>Jumlah Tersedia</label>
            <input type="number" name="jumlah_tersedia" value="<?= $data['jumlah_tersedia'] ?? '' ?>" required>

            <label>Lokasi</label>
            <input type="text" name="lokasi" value="<?= $data['lokasi'] ?? '' ?>" required>

            <label>Kode Barang</label>
            <input type="text" name="kode" value="<?= $data['kode'] ?? '' ?>" required>

            <div style="display: flex; gap: 10px; align-items: center;">
                <button type="submit">Simpan</button>
                <a href="index.php">Batal</a>
            </div>
        </form>
    </div>
</body>

</html>
