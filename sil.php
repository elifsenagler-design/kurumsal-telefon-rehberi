<?php
include 'db.php'; // Veritabanı bağlantısını çağırıyoruz

// URL'den gelen bir 'id' var mı kontrol ediyoruz (Örn: sil.php?id=5)
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Güvenlik kuralı: Prepared Statement kullanarak silme işlemi
    $sorgu = $db->prepare("DELETE FROM personel WHERE id = ?");
    $sorgu->execute([$id]);
}

// Silme işlemi bittikten sonra otomatik olarak ana sayfaya (index.php) geri dön
header("Location: index.php");
exit;
?>
