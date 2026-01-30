<?php
try {
    // PDO ile güvenli bağlantı [cite: 35]
    $db = new PDO("mysql:host=localhost;dbname=sirket_rehberi;charset=utf8", "root", "");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Bağlantı hatası: " . $e->getMessage();
}
?>
