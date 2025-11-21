<?php

include 'fungsi.php';

// Cek login
requireLogin();

// Cek akses superadmin
if (!isSuperAdmin()) {
    echo "Anda tidak memiliki akses ke halaman ini.";
    exit();
}

$id = $_GET['id'] ?? null;
$data = null;

// Jika ada ID, ambil data user untuk diedit
if ($id) {
    $data = $koneksi->query("SELECT * FROM users WHERE id = $id")->fetch_assoc();
}

// Proses simpan data user (Tambah/Edit)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $fullname = $_POST['fullname'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    if ($id) {
        // Update data user
        $stmt = $koneksi->prepare("UPDATE users SET username=?, fullname=?, password=?, role=? WHERE id=?");
        $stmt->bind_param("ssssi", $username, $fullname, $password, $role, $id);
    } else {
        // Insert data user baru
        $stmt = $koneksi->prepare("INSERT INTO users (username, fullname, password, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $fullname, $password, $role);
    }

    $stmt->execute();
    header("Location: users.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Form User</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div>
        <h2><?= $id ? 'Edit' : 'Tambah' ?> User</h2>
        <form method="post">
            <label>Username</label>
            <input type="text" name="username" value="<?= $data['username'] ?? '' ?>" required>

            <label>Full Name</label>
            <input type="text" name="fullname" value="<?= $data['fullname'] ?? '' ?>" required>

            <label>Password</label>
            <input type="password" name="password" value="<?= $data['password'] ?? '' ?>" required>

            <label>Role</label>
            <select name="role" required>
                <option value="admin" <?= (isset($data['role']) && $data['role'] == 'admin') ? 'selected' : '' ?>>Admin</option>
                <option value="superadmin" <?= (isset($data['role']) && $data['role'] == 'superadmin') ? 'selected' : '' ?>>Super Admin</option>
            </select>

            <div style="display: flex; gap: 10px; align-items: center;">
                <button type="submit">Simpan</button>
                <a href="index.php">Batal</a>
            </div>
        </form>
    </div>
</body>

</html>