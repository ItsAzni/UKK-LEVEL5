<?php

include 'db.php';

requireLogin();

$transaksi = $connection->query("SELECT t.*, b.nama FROM transaksi t JOIN barang b ON t.id_barang = b.id ORDER BY t.tanggal DESC")->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Riwayat Transaksi</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div>
        <nav style="display: flex; gap: 15px;">
            <a href="index.php">📦Barang</a>
            <a href="transaksi.php">📝Transaksi</a>
            <a href="auth.php?logout=1" style="color: red;">🚪Logout</a>
        </nav>

        <h2 style="margin: 20px 0;">Riwayat Transaksi</h2>

        <table border="1" cellpadding="10" cellspacing="0">
            <thead>
                <tr>
                    <th>Barang</th>
                    <th>Peminjam</th>
                    <th>Jumlah</th>
                    <th>Status</th>
                    <th>Catatan</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($transaksi as $t): ?>
                    <tr>
                        <td><?= $t['nama'] ?></td>
                        <td><?= $t['peminjam'] ?></td>
                        <td><?= $t['jumlah'] ?></td>
                        <td style="color: <?= $t['kategori'] == 'pinjam' ? 'red' : 'green' ?>">
                            <?= ucfirst($t['kategori']) ?>
                        </td>
                        <td><?= $t['catatan'] ?></td>
                        <td><?= $t['tanggal'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>