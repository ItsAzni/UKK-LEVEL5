<?php

include 'db.php';

requireLogin();

$id = $_GET['id'];
$action = $_GET['action']; // 'pinjam' or 'kembali'
$item = $connection->query("SELECT * FROM barang WHERE id = $id")->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $peminjam = $_POST['peminjam'];
    $jumlah = $_POST['jumlah'];
    $catatan = $_POST['catatan'];

    $valid = true;
    if ($action == 'pinjam' && $jumlah > $item['jumlah_tersedia']) $valid = false;
    if ($action == 'kembali' && $jumlah > ($item['jumlah'] - $item['jumlah_tersedia'])) $valid = false;

    if ($valid) {
        $stmt = $connection->prepare("INSERT INTO transaksi (id_barang, peminjam, jumlah, kategori, catatan) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("isiss", $id, $peminjam, $jumlah, $action, $catatan);
        $stmt->execute();

        $operator = ($action == 'pinjam') ? '-' : '+';
        $connection->query("UPDATE barang SET jumlah_tersedia = jumlah_tersedia $operator $jumlah WHERE id = $id");

        header("Location: transaksi.php");
        exit();
    } else {
        echo "<script>alert('Jumlah tidak valid!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Transaksi Barang</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div>
        <h2><?= ucfirst($action) ?>: <?= $item['nama'] ?></h2>
        <p>Stok Tersedia: <?= $item['jumlah_tersedia'] ?> / <?= $item['jumlah'] ?></p>

        <form method="post">
            <label>Nama Peminjam</label>
            <input type="text" name="peminjam" required>

            <label>Jumlah</label>
            <input type="number" name="jumlah" value="1" min="1" required>

            <label>Catatan</label>
            <textarea name="catatan" required></textarea>

            <div style="display: flex; gap: 10px; align-items: center;">
                <button type="submit">Simpan</button>
                <a href="index.php">Batal</a>
            </div>
        </form>
    </div>
</body>

</html>