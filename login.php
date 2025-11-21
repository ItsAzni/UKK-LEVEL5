<?php

include 'fungsi.php';

// Jika sudah login, redirect ke index
if (isLoggedIn()) {
    header("Location: index.php");
    exit();
}

// Proses login jika ada request POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Ambil data user berdasarkan username
    $user = $koneksi->query("SELECT * FROM users WHERE username = '$username'")->fetch_assoc();
    
    // Verifikasi password
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_role'] = $user['role'];
        header("Location: index.php");
        exit();
    }
    $error = "Login gagal!";
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div style="margin-top: 100px;">
        <h2 style="text-align: center; margin-bottom: 15px;">LOGIN</h2>

        <?php if (isset($error)) echo "<p style='color:red; text-align:center; margin-bottom: 15px;'>$error</p>"; ?>

        <form method="post">
            <label>Username</label>
            <input type="text" name="username" required>
            <label>Password</label>
            <input type="password" name="password" required>
            <button type="submit">Login</button>
        </form>
    </div>
</body>

</html>