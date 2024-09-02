<?php
require "bootstrap.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biz Kimiz ?</title>
    <style>
        .custom-container {
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .custom-img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }
        .custom-heading {
            margin-top: 20px;
            margin-bottom: 20px;
            font-size: 2rem;
            font-weight: bold;
            color: #343a40;
        }
        .custom-paragraph {
            line-height: 1.6;
            color: #495057;
        }
    </style>
</head>
<body class="bg-primary-subtle">
<div class="container custom-container">
        <div class="row d-flex justify-content-center">
            <div class="col-lg-8 col-md-10 col-sm-12 text-center">
                <img src="image/egenotes_logo.png" alt="EgeNotes Logo" class="custom-img">
                <h2 class="custom-heading">Biz Kimiz?</h2>
                <p class="custom-paragraph">
                    EgeNotes Projesi bir Doğu Akdeniz Üniversitesi 2. sınıf öğrencisi tarafından tek başına 1 hafta ( günde 2 3 saat ) süreyle yapımı tamamlanmıştır, güncellemelerini almaya devam etmektedir.
                </p>
                <h2 class="custom-heading">Projenin Amacı Nedir ?</h2>
                <p class="custom-paragraph">
                    EgeNotes Projesinin temel amacı gelecek dönem alacak olduğu "Sunucu Odaklı Internet Programcılığı" Dersi için PHP Yeteneklerinin ne durumda olduğunun tespiti için yapılmıştır. Yetenek tespiti sırasında projenin bir amacı olması için gündelik hayattan bir örnek bularak yüksek güvenlikli Not Defteri projesi olarak EgeNotes projesini hayata getirdi.
                </p>
                <h2 class="custom-heading">Neden EgeNotes ?</h2>
                <p class="custom-paragraph">
                    Eğer istenirse çok rahat bir şekilde giriş / çıkış yapılabilen ( Hesap paylaşımını mümkün kılan. ). Eğer istenirse hesap paylaşımını imkaansızlaştıran yüksek güvenlikli bir Çevrimici Not Defteri projesidir. Tuttuğunuz notları güvenle saklayabilir ve her yerden erişim sağlayabilirsiniz.
                </p>
                <h2 class="custom-heading">Güvenlik</h2>
                <p class="custom-paragraph">
                    EgeNotes ile alınan notların veya herhangi bir hassas bilginin 3. taraflarla paylaşılması mümkün değildir. Çünkü bu tarz bir kayıt tutulmamaktadır. Kullanılan şifreler özel tek yönlü şifreleme yöntemleriyle şifrelenerek bizler tarafından asla görüntülenemez.
                </p>
                <h2 class="custom-heading">Kullanmaya Başlayın.</h2>
                <p class="custom-paragraph">
                    Kayıt olup / Giriş yaparak kullanmaya hemen başlayabilirsiniz.
                </p>
                <a href="login.php" class="btn btn-primary">Kullanmaya Başla</a>
            </div>
        </div>
    </div>
</body>
</html>