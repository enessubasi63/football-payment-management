<?php
/**
 * db.php
 * ------------------------------------
 * Bu dosya MySQL veritabanına güvenli bir PDO bağlantısı sağlar.
 * Veritabanı bilgileri üretim ortamında güvenli bir şekilde saklanmalıdır.
 */

// Ortam degiskenlerinden veritabani bilgilerini oku
$envHost    = getenv('DB_HOST') ?: 'localhost';
$envName    = getenv('DB_NAME');
$envUser    = getenv('DB_USER');
$envPass    = getenv('DB_PASS');
$envCharset = getenv('DB_CHARSET') ?: 'utf8mb4';

// Gerekli degiskenler tanimli degilse hata ver
if ($envName === false || $envUser === false || $envPass === false) {
    die('Database environment variables (DB_NAME, DB_USER, DB_PASS) must be set.');
}

// Mevcut kodla uyum icin sabitleri tanimla
define('DB_HOST', $envHost);
define('DB_NAME', $envName);
define('DB_USER', $envUser);
define('DB_PASS', $envPass);
define('DB_CHARSET', $envCharset);

try {
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Hata ayıklamayı kolaylaştırır.
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Varsayılan fetch modunu düzenler.
        PDO::ATTR_EMULATE_PREPARES   => false,                  // Gerçek prepared statement kullanımı.
    ];

    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
} catch (PDOException $e) {
    // Üretim ortamında hata mesajını loglamak ve kullanıcıya göstermemek önerilir.
    die("Veritabanı bağlantı hatası: " . $e->getMessage());
}
