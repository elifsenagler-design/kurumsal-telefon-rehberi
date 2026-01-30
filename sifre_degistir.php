<?php
include 'header.php';
include 'db.php';

if ($_POST) {
    $yeni_sifre = $_POST['yeni_sifre'];
    $id = $_SESSION['kullanici_id'];

    $guncelle = $db->prepare("UPDATE kullanicilar SET sifre = ? WHERE id = ?");
    if($guncelle->execute([$yeni_sifre, $id])) {
        $mesaj = "Şifre başarıyla güncellendi!";
    }
}
?>
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h4>Şifre Değiştir</h4>
            <?php if(isset($mesaj)) echo "<div class='alert alert-success'>$mesaj</div>"; ?>
            <form method="POST" class="card card-body shadow-sm">
                <div class="mb-3">
                    <label>Yeni Şifre</label>
                    <input type="password" name="yeni_sifre" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-warning">Şifreyi Güncelle</button>
            </form>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>