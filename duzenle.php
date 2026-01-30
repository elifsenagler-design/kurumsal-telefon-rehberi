<?php 
include 'db.php'; 
include 'header.php'; 

// 1. ADIM: Düzenlenecek personelin mevcut bilgilerini veritabanından çekme
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sorgu = $db->prepare("SELECT * FROM personel WHERE id = ?");
    $sorgu->execute([$id]);
    $personel = $sorgu->fetch(PDO::FETCH_ASSOC);

    // Personel bulunamazsa geri gönder
    if (!$personel) {
        header("Location: index.php");
        exit;
    }
}

// 2. ADIM: Form gönderildiğinde veritabanını güncelleme
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ad = $_POST['ad'];
    $soyad = $_POST['soyad'];
    $telefon = $_POST['telefon'];
    $email = $_POST['email'];
    $departman = $_POST['departman'];
    $id = $_POST['id'];
    $mevcut_foto = $_POST['mevcut_foto'];

    // Yeni fotoğraf yüklendi mi kontrolü
    if (isset($_FILES['fotograf']) && $_FILES['fotograf']['error'] == 0) {
        $uzanti = pathinfo($_FILES['fotograf']['name'], PATHINFO_EXTENSION);
        $yeni_dosya_adi = time() . "." . $uzanti;
        move_uploaded_file($_FILES['fotograf']['tmp_name'], "uploads/" . $yeni_dosya_adi);
        $güncellenecek_foto = $yeni_dosya_adi;
    } else {
        $güncellenecek_foto = $mevcut_foto; // Değişmediyse eskisi kalsın
    }

    // PDO Güvenli Güncelleme Sorgusu
    $guncelle = $db->prepare("UPDATE personel SET ad=?, soyad=?, telefon=?, email=?, departman=?, fotograf=? WHERE id=?");
    $sonuc = $guncelle->execute([$ad, $soyad, $telefon, $email, $departman, $güncellenecek_foto, $id]);

    if ($sonuc) {
        header("Location: index.php?durum=ok");
        exit;
    }
}
?>

<h2>Personel Bilgilerini Düzenle</h2>
<form action="duzenle.php" method="POST" enctype="multipart/form-data" class="mt-4">
    <input type="hidden" name="id" value="<?= $personel['id'] ?>">
    <input type="hidden" name="mevcut_foto" value="<?= $personel['fotograf'] ?>">

    <div class="row">
        <div class="col-md-6 mb-3">
            <label>Ad</label>
            <input type="text" name="ad" class="form-control" value="<?= htmlspecialchars($personel['ad']) ?>" required>
        </div>
        <div class="col-md-6 mb-3">
            <label>Soyad</label>
            <input type="text" name="soyad" class="form-control" value="<?= htmlspecialchars($personel['soyad']) ?>" required>
        </div>
    </div>
    <div class="mb-3">
        <label>Telefon</label>
        <input type="text" name="telefon" class="form-control" value="<?= htmlspecialchars($personel['telefon']) ?>" required>
    </div>
    <div class="mb-3">
        <label>E-posta</label>
        <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($personel['email']) ?>">
    </div>
    <div class="mb-3">
        <label>Departman</label>
        <input type="text" name="departman" class="form-control" value="<?= htmlspecialchars($personel['departman']) ?>">
    </div>
    <div class="mb-3">
        <label>Fotoğrafı Değiştir (İstemiyorsanız boş bırakın)</label>
        <input type="file" name="fotograf" class="form-control">
        <small>Mevcut: <?= $personel['fotograf'] ? $personel['fotograf'] : 'Yok' ?></small>
    </div>
    
    <button type="submit" class="btn btn-warning">Güncelle</button>
    <a href="index.php" class="btn btn-secondary">Vazgeç</a>
</form>

<?php include 'footer.php'; ?>
