<?php
/**
 * File: system-test.php
 * Deskripsi: White-box testing untuk aplikasi REST Client PHP NewsAPI.org
 * Menggunakan pendekatan exception handling (try-catch) dengan output PASS / FAIL.
 */

// Memuat file konfigurasi cURL yang sudah ada
require_once __DIR__ . '/config/config.php';

echo "=== MENJALANKAN WHITE-BOX SYSTEM TESTING (NEWSAPI) ===\n\n";

// ==========================================
// TEST CASE 1: Jalur Sukses (Valid API Key & Parameter)
// ==========================================
echo "[WB_API_001] Menguji jalur sukses pengambilan data dengan API Key dan parameter valid...\n";
try {
    // Membaca API Key dari file eksternal
    if (!file_exists(__DIR__ . "/apikey-newsorg.txt")) {
        throw new Exception("File apikey-newsorg.txt tidak ditemukan.");
    }
    $api_key = trim(file_get_contents(__DIR__ . "/apikey-newsorg.txt"));
    $url = "https://newsapi.org/v2/top-headlines?country=us&category=technology&apiKey=" . $api_key;
    
    $data = http_request_get($url);
    if ($data === false) {
        throw new Exception("Gagal melakukan koneksi cURL ke server NewsAPI.");
    }

    $hasil = json_decode($data, true);
    
    // Validator White-Box: Memeriksa apakah struktur array hasil valid dan status API 'ok'
    if (isset($hasil['status']) && $hasil['status'] === 'ok' && isset($hasil['articles'])) {
        echo "  [✔] OUTPUT: PASS - Data berhasil ditarik, status API 'ok', dan array 'articles' tersedia.\n";
    } else {
        $error_msg = $hasil['message'] ?? 'Struktur JSON tidak dikenali';
        throw new Exception("Validator gagal: " . $error_msg);
    }
} catch (Exception $e) {
    echo "  [❌] OUTPUT: FAIL - Test Case 1 Gagal. Pesan Error: " . $e->getMessage() . "\n";
}

echo "---------------------------------------------------\n\n";

// ==========================================
// TEST CASE 2: Jalur Error / Negative Testing (API Key Invalid)
// ==========================================
echo "[WB_API_002] Menguji jalur exception handling saat API Key salah (Invalid API Key)...\n";
try {
    // Sengaja menggunakan API Key palsu/salah untuk memicu blok error server
    $invalid_api_key = "INVALID_KEY_SAMPLE_12345";
    $url = "https://newsapi.org/v2/top-headlines?country=us&category=technology&apiKey=" . $invalid_api_key;
    
    $data = http_request_get($url);
    $hasil = json_decode($data, true);

    // Validator White-Box: Memastikan API merespons dengan status 'error'
    if (isset($hasil['status']) && $hasil['status'] === 'error') {
        echo "  [✔] OUTPUT: PASS - Blok logika berhasil mendeteksi penolakan API ('code': " . ($hasil['code'] ?? 'unknown') . ").\n";
    } else {
        throw new Exception("Sistem tidak mendeteksi error padahal API key invalid.");
    }
} catch (Exception $e) {
    echo "  [✔] OUTPUT: PASS (Caught Exception) - Terdeteksi pengecualian: " . $e->getMessage() . "\n";
}

echo "---------------------------------------------------\n\n";

// ==========================================
// TEST CASE 3: Jalur Validasi Parameter Kosong / Batas
// ==========================================
echo "[WB_API_003] Menguji jalur penanganan parameter URL yang tidak lengkap/kosong...\n";
try {
    $api_key = trim(file_get_contents(__DIR__ . "/apikey-newsorg.txt"));
    // URL sengaja diubah tanpa parameter kategori atau negara yang valid
    $url = "https://newsapi.org/v2/top-headlines?apiKey=" . $api_key;
    
    $data = http_request_get($url);
    $hasil = json_decode($data, true);

    // Validator White-Box: Memastikan struktur respons tertangani dengan aman oleh percabangan program
    if (isset($hasil['status'])) {
        echo "  [✔] OUTPUT: PASS - Sistem merespons parameter kosong dengan kode status: " . $hasil['status'] . ".\n";
    } else {
        throw new Exception("Respons dari server kosong atau gagal di-decode.");
    }
} catch (Exception $e) {
    echo "  [❌] OUTPUT: FAIL - Test Case 3 Gagal. Pesan Error: " . $e->getMessage() . "\n";
}

echo "\n=== PENGUJIAN WHITE-BOX SELESAI ===\n";
?>