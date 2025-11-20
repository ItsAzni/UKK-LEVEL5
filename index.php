<?php

include 'db.php';

requireLogin();

// Handle Delete
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $connection->query("DELETE FROM barang WHERE id = $id");
    header("Location: index.php");
    exit();
}

$items = $connection->query("SELECT * FROM barang")->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Daftar Barang</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div>
        <nav style="display: flex; gap: 15px;">
            <a href="index.php">📦Barang</a>
            <a href="transaksi.php">📝Transaksi</a>
            <a href="auth.php?logout=1" style="color: red;">🚪Logout</a>
        </nav>

        <div style="display: flex; justify-content: space-between; margin: 20px 0;">
            <h2>Daftar Barang</h2>
            <a href="tambah_barang.php">+ Tambah Barang</a>
        </div>

        <table border="1" cellpadding="10" cellspacing="0">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Deskripsi</th>
                    <th>Stok</th>
                    <th>Tersedia</th>
                    <th>Lokasi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item): ?>
                    <tr>
                        <td><?= $item['nama'] ?></td>
                        <td><?= $item['deskripsi'] ?></td>
                        <td><?= $item['jumlah'] ?></td>
                        <td><?= $item['jumlah_tersedia'] ?></td>
                        <td><?= $item['lokasi'] ?></td>
                        <td>
                            <a href="tambah_barang.php?id=<?= $item['id'] ?>">Edit</a> |
                            <a href="peminjaman.php?action=pinjam&id=<?= $item['id'] ?>">Pinjam</a> |
                            <?php if ($item['jumlah_tersedia'] < $item['jumlah']): ?>
                                <a href="peminjaman.php?action=kembali&id=<?= $item['id'] ?>">Kembalikan</a> |
                            <?php endif; ?>
                            <a href="index.php?delete_id=<?= $item['id'] ?>" onclick="return confirm('Hapus?')">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>