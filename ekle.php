<?php 
include 'db.php'; // Veritabanı bağlantısı [cite: 40]
include 'header.php'; // Sayfa üstü [cite: 41]

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ad = $_POST['ad'];
    $soyad = $_POST['soyad'];
    $telefon = $_POST['telefon'];
    $email = $_POST['email'];
    $departman = $_POST['departman'];
    
    $dosya_adi = ""; 

    // Fotoğraf yükleme ve güvenlik kontrolleri [cite: 23, 24]
    if (isset($_FILES['fotograf']) && $_FILES['fotograf']['error'] == 0) {
        $izin_verilenler = ['image/jpg', 'image/jpeg', 'image/png'];
        $dosya_tipi = $_FILES['fotograf']['type'];
        
        if (in_array($dosya_tipi, $izin_verilenler)) {
            // Benzersiz isim oluşturma (Bonus görev) [cite: 48]
            $uzanti = pathinfo($_FILES['fotograf']['name'], PATHINFO_EXTENSION);
            $dosya_adi = time() . "_" . rand(100, 999) . "." . $uzanti;
            
            // Dosyayı uploads/ klasörüne taşı [cite: 23]
            move_uploaded_file($_FILES['fotograf']['tmp_name'], "uploads/" . $dosya_adi);
        }
    }

    // PDO ve Prepared Statements kullanarak güvenli kayıt [cite: 35, 36, 38]
    $sorgu = $db->prepare("INSERT INTO personel (ad, soyad, telefon, email, departman, fotograf) VALUES (?, ?, ?, ?, ?, ?)");
    $sorgu->execute([$ad, $soyad, $telefon, $email, $departman, $dosya_adi]);

    echo "<div class='alert alert-success'>Personel başarıyla eklendi!</div>";
}
?>

<h2>Yeni Personel Ekle</h2>
<form action="ekle.php" method="POST" enctype="multipart/form-data" class="mt-4">
    <div class="row">
        <div class="col-md-6 mb-3"><label>Ad</label><input type="text" name="ad" class="form-control" required></div>
        <div class="col-md-6 mb-3"><label>Soyad</label><input type="text" name="soyad" class="form-control" required></div>
    </div>
    <div class="mb-3"><label>Telefon</label><input type="text" name="telefon" class="form-control" required></div>
    <div class="mb-3"><label>E-posta</label><input type="email" name="email" class="form-control"></div>
    <div class="mb-3"><label>Departman</label><input type="text" name="departman" class="form-control"></div>
    <div class="mb-3"><label>Personel Fotoğrafı (.jpg, .png)</label><input type="file" name="fotograf" class="form-control"></div>
    <button type="submit" class="btn btn-primary">Kaydet</button>
    <a href="index.php" class="btn btn-secondary">Geri Dön</a>
</form>

<?php include 'footer.php'; ?>ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

