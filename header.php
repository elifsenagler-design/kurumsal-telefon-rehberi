<?php
session_start();
if (!isset($_SESSION['oturum'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kurumsal Telefon Rehberi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="index.php">🏢 Şirket Rehberi</a>
        <div class="navbar-nav ms-auto">
            <a class="nav-link text-white" href="index.php">Personel Listesi</a>
            <a class="nav-link text-white" href="ekle.php">Yeni Personel Ekle</a>
            <a class="nav-link text-warning fw-bold" href="sifre_degistir.php">Şifre Değiştir</a>
            <a class="nav-link text-danger fw-bold" href="cikis.php">Çıkış Yap</a>
        </div>
    </div>
</nav>

<div class="container">


    