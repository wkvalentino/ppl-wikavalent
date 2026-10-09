<?php
//file: test_name.php
require_once 'Validatornama.php';

// Test Case 1: Nama lengkap valid (huruf dan spasi)
try {
    $result = validateName('Budi Santoso');
    echo "PASS: Nama 'Budi Santoso' diterima\n";
} catch (Exception $e) {
    echo "FAIL: Nama 'Budi Santoso' tidak diterima. Error: " . $e->getMessage() . "\n";
}

// Test Case 2: Nama mengandung angka (harus ditolak)
try {
    $result = validateName('Budi123');
    echo "FAIL: Nama 'Budi123' seharusnya ditolak\n";
} catch (Exception $e) {
    echo "PASS: Nama 'Budi123' ditolak. Error: " . $e->getMessage() . "\n";
}

// Test Case 3: Input data kosong (harus ditolak)
try {
    $result = validateName('');
    echo "FAIL: Nama kosong seharusnya ditolak\n";
} catch (Exception $e) {
    echo "PASS: Nama kosong ditolak. Error: " . $e->getMessage() . "\n";
}

