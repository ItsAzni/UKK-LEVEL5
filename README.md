# Aplikasi Inventaris Barang (UKK Level 5 SMK Telkom Lampung)

Aplikasi sederhana berbasis web untuk pengelolaan inventaris barang, peminjaman, dan manajemen user.

## Fitur Utama

- **Login & Logout**: Sistem autentikasi pengguna.
- **Manajemen Barang**: Tambah, Edit, Hapus, dan Lihat daftar barang.
- **Transaksi**: Fitur Peminjaman dan Pengembalian barang dengan validasi stok otomatis.
- **Manajemen User**: (Khusus Super Admin) Kelola pengguna aplikasi dengan role Admin atau Super Admin.
- **Riwayat Transaksi**: Log aktivitas peminjaman dan pengembalian barang.

## Struktur Database

Berikut adalah desain relasi tabel (ERD) yang digunakan dalam aplikasi ini:

![Skema Database](assets/database.png)

> File database SQL tersedia di: `assets/database.sql`

## Utility: Membuat Password Hash

Aplikasi ini menggunakan enkripsi `password_hash()` (Bcrypt) untuk keamanan. Password tidak disimpan dalam bentuk teks biasa (plain text).

Jika Anda ingin membuat user baru secara manual lewat database (phpMyAdmin), Anda memerlukan hash dari password tersebut. Gunakan script sederhana berikut:

```php
<?php
// Ganti 'rahasia123' dengan password yang Anda inginkan
$password = 'rahasia123';

// Generate hash
$hash = password_hash($password, PASSWORD_DEFAULT);

echo "Password: " . $password . "<br>";
echo "Hash: " . $hash;
?>
```

**Cara pakai:**

1. Buat file baru misal `password.php`.
2. Paste kode di atas.
3. Buka di browser, lalu copy hasil hash-nya ke kolom `password` di tabel `users`.
