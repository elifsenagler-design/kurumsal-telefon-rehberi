<?php
session_start();
include 'db.php';

if ($_POST) {
    $kadi = $_POST['kadi'];
    $sifre = $_POST['sifre'];

    $sorgu = $db->prepare("SELECT * FROM kullanicilar WHERE kullanici_adi = ? AND sifre = ?");
    $sorgu->execute([$kadi, $sifre]);
    $kullanici = $sorgu->fetch();

    if ($kullanici) {
        $_SESSION['oturum'] = true;
        $_SESSION['kullanici_id'] = $kullanici['id'];
        header("Location: index.php");
    } else {
        $hata = "Kullanıcı adı veya şifre hatalı!";
    }
}
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <h3 class="text-center">Sistem Girişi</h3>
            <?php if(isset($hata)) echo "<div class='alert alert-danger'>$hata</div>"; ?>
            <form method="POST">
                <input type="text" name="kadi" class="form-control mb-2" placeholder="Kullanıcı Adı" required>
                <input type="password" name="sifre" class="form-control mb-2" placeholder="Şifre" required>
                <button type="submit" class="btn btn-primary w-100">Giriş Yap</button>
            </form>
        </div>
    </div>
</div>
