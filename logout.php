<?php
session_start(); // Mulai sesi

// Hapus semua session
session_unset();

// Hancurkan session
session_destroy();

// Arahkan kembali ke halaman login setelah logout
header("Location: index.php");
exit;
