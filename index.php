<?php 
// Veritabanı bağlantısı ve tasarımları dahil ediyoruz
include 'db.php';     // [cite: 40]
include 'header.php'; // [cite: 41]

// Arama işlemi için kontrol yapıyoruz 
$arama_kelimesi = isset($_GET['ara']) ? $_GET['ara'] : '';

if ($arama_kelimesi != '') {
    // Arama yapılıyorsa (SQL Injection önlemi için Prepared Statement) [cite: 36, 38]
    $sorgu = $db->prepare("SELECT * FROM personel WHERE ad LIKE ? OR soyad LIKE ?");
    $sorgu->execute(["%$arama_kelimesi%", "%$arama_kelimesi%"]);
} else {
    // Arama yoksa tüm listeyi çek [cite: 16]
    $sorgu = $db->query("SELECT * FROM personel");
}
$personeller = $sorgu->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Personel Listesi</h2>
    <a href="ekle.php" class="btn btn-success">➕ Yeni Personel Ekle</a>
</div>

<form action="index.php" method="GET" class="mb-4">
    <div class="input-group">
        <input type="text" name="ara" class="form-control" placeholder="İsim veya soyisim ile ara..." value="<?= htmlspecialchars($arama_kelimesi) ?>">
        <button type="submit" class="btn btn-primary">Ara</button>
    </div>
</form>

<table class="table table-striped border">
    <thead class="table-dark">
        <tr>
            <th>Fotoğraf</th>
            <th>Ad</th>
            <th>Soyad</th>
            <th>Telefon</th>
            <th>Departman</th>
            <th>İşlemler</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($personeller as $kisi): ?>
        <tr>
            <td>
                <?php if ($kisi['fotograf']): ?>
                    <img src="uploads/<?= $kisi['fotograf'] ?>" width="50" height="50" class="rounded-circle">
                <?php else: ?>
                    <img src="https://via.placeholder.com/50" class="rounded-circle">
                <?php endif; ?>
            </td>
            <td><?= htmlspecialchars($kisi['ad']) ?></td>
            <td><?= htmlspecialchars($kisi['soyad']) ?></td>
            <td><?= htmlspecialchars($kisi['telefon']) ?></td>
            <td><?= htmlspecialchars($kisi['departman']) ?></td>
            <td>
                <a href="duzenle.php?id=<?= $kisi['id'] ?>" class="btn btn-sm btn-warning">Düzenle</a>
                <a href="sil.php?id=<?= $kisi['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bu personeli silmek istediğinize emin misiniz?')">Sil</a>
            </td>
        </tr>
        <?php endforeach; ?>
        
        <?php if (empty($personeller)): ?>
        <tr>
            <td colspan="6" class="text-center">Kayıtlı personel bulunamadı.</td>
        </tr>
        <?php endif; ?>
    </tbody>
    <?php foreach ($personeller as $kisi): ?>
<tr>
    <td>
        <?php if ($kisi['fotograf']): ?>
            <img src="uploads/<?= $kisi['fotograf'] ?>" width="50" height="50" class="rounded-circle">
        <?php else: ?>
            <img src="https://via.placeholder.com/50" class="rounded-circle">
        <?php endif; ?>
    </td>
    <td><?= htmlspecialchars($kisi['ad']) ?></td>
    <td><?= htmlspecialchars($kisi['soyad']) ?></td>
    <td><?= htmlspecialchars($kisi['telefon']) ?></td>
    <td><?= htmlspecialchars($kisi['departman']) ?></td>
    <td>
        <a href="duzenle.php?id=<?= $kisi['id'] ?>" class="btn btn-sm btn-warning">Düzenle</a>
        <a href="sil.php?id=<?= $kisi['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bu personeli silmek istediğinize emin misiniz?')">Sil</a>
    </td>
</tr>
<?php endforeach; ?>
</table>

<?php include 'footer.php'; ?>
