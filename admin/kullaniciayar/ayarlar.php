<?php
require "navbar.php";
$baglan = mysqli_connect("localhost","root","","egenots");
$query = "select * from auth where username ='".$_SESSION['login']."';";
$result = mysqli_fetch_assoc(mysqli_query($baglan,$query));
if(!$result['yoneticimi']){
    header("location:../../login.php");
}
mysqli_close($baglan);



if(isset($_COOKIE['ekleme'])){
    header("location:../kullanicisec.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php
    require "bootstrap.php";
    ?>
    <style>
    #logo1{
        max-width:150px;
    }
    #floatingTextarea{
        height: 80%;
        resize: none;
    }
    .bos{
        min-width: 100%;
    }
    .btn{
        width:100%;
    }
    .status-active{
        color:green;
        font-weight: bold;
    }
    .status-deactive{
        color:red;
        font-weight: bold;
    }
    </style>
</head>

<?php
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['sifre'])){
    $yenisifre1 = htmlspecialchars(trim(stripslashes($_POST['ysifre'])));
    $baglan = mysqli_connect("localhost","root","","egenots");
    $username = $_COOKIE['login1'];
    $query = "select * from auth where username ='".$username."';";
    $result = mysqli_query($baglan,$query);
    if($result){
        $result = mysqli_fetch_assoc($result);
        $hashed = password_hash($yenisifre1,PASSWORD_DEFAULT);
        $query = "update auth set password ='".$hashed."' where username = '".$username."';";
        $result = mysqli_query($baglan,$query);
        if($result){
            echo "<div class='alert alert-success mt-0 text-center'>İşlem başarıyla gerçekleşti</div>";
            $query = "select * from auth where username ='".$username."';";
            $result = mysqli_query($baglan,$query);
            $result = mysqli_fetch_assoc($result);
            setcookie("cpassword",1,time()+120);
            setcookie("login",1,time()-3600);
            session_destroy();
            header("location:login.php");
        }

    }
    header("location:ayarlar.php");
    mysqli_close($baglan);
}
?>
<body class="bg-primary-subtle">
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-6">
                <div>
                    <h1 class="text-center mt-3">Güvenlik</h1>
                    <h2 class="text-center mt-3">Yönetilen hesap : <?php echo $_COOKIE['login1'];?></h2>
                    <form method="POST">
                    <?php
                    $baglan = mysqli_connect("localhost","root","","egenots");
                    $query = "select * from auth where username ='".$_COOKIE['login1']."';";
                    $result = mysqli_fetch_assoc(mysqli_query($baglan,$query));
                    ?>
                    <?php if($result['active']):?>
                        <button type="submit" name="deaktif" class="btn btn-danger">Hesabı deaktif et.</button>
                    <?php else: ?>
                        <button type="submit" name="aktif" class="btn btn-success">Hesabı aktif et.</button>
                    <?php endif;?>
                    <?php

                    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['aktif'])){
                        $query = "update auth set active ='1' where username='".$_COOKIE['login1']."';";
                        $result = mysqli_query($baglan,$query);
                        if($result){
                            echo "<div class='alert alert-success text-center mt-0'>İşlem başarıyla gerçekleşti.</div>";
                        }
                    }
                    
                    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['deaktif'])){
                        $query = "update auth set active ='0' where username='".$_COOKIE['login1']."';";
                        $result = mysqli_query($baglan,$query);
                        if($result){
                            echo "<div class='alert alert-success text-center mt-0'>İşlem başarıyla gerçekleşti.</div>";
                        }
                    }
                    mysqli_close($baglan);
                    ?>
                    </form>
                    <form method="POST">
                        <div class="form-group mt-2">
                            <label for="exampleInputPassword1">Yeni Şifreniz :</label>
                            <input type="password" name="ysifre" class="form-control" id="exampleInputPassword1" placeholder="Yeni Şifreyi Giriniz.">
                        </div>
                        <button type="submit" name="sifre" class="btn btn-primary mt-2">Güncelle</button>
                    </form>
                    <?php
                    $baglan = mysqli_connect("localhost","root","","egenots");
                    $ip = getUserIP();
                    $email = $result['email'];
                    $dogum = $result['dogum'];
                    $adres = $result['adres'];
                    $telno = $result['telno'];
                    $yoneticimi = $result['yoneticimi'];
                    $dip = 0;
                    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['ip'])){
                        $query = "UPDATE auth SET ip ='".$ip."' where username ='".$_COOKIE['login1']."';";
                        $result = mysqli_query($baglan,$query);
                        if($result){
                            echo "<div class='alert alert-success text-center mt-0'>İşlem başarılı</div>";
                        $dip = $ip;
                        }
                        else{
                            echo "<div class='alert alert-danger text-center mt-0'>İşlem sırasında hata.</div>";
                        }
                        header("location:ayarlar.php");
                    }
                    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['dip'])){
                        $query = "UPDATE auth SET ip ='' where username ='".$_COOKIE['login1']."';";
                        $result = mysqli_query($baglan,$query);
                        if($result){
                            echo "<div class='alert alert-success text-center mt-0'>İşlem başarılı</div>";
                        }
                        else{
                            echo "<div class='alert alert-danger text-center mt-0'>İşlem sırasında hata.</div>";
                        }
                        header("location:ayarlar.php");
                    }

                    
                    $query = "select * from auth where username ='".$_COOKIE['login1']."';";
                    $result = mysqli_query($baglan,$query);
                    $result = mysqli_fetch_assoc($result);
                    
                    ?>
                    <!-- İp Koruması -->
                    <form method="POST">
                    <div class="card">
                        <div class="card-header">
                        <?php if($result['ip']):?>
                            <small class="status-active">Açık</small>
                            <?php else: ?>
                                <small class="status-deactive">Kapalı</small>
                            <?php endif; ?>

                        </div>
                        <div class="card-body">
                            <h5 class="card-title">İp Koruması</h5>
                            <p class="card-text">Eğer hesabınızda çok hassas veriler saklıyorsanız aktif etmeniz tavsiye edilir, Aktif ettiğiniz zaman şu an geçerli olan ip adresiniz haricinde herhangi bir ip adresinden giriş yapılamaz.</p>
                            <?php if($ip =! '::1' && getLocation(getUserIP())[1] != 'TR'): ?>
                            <p class="card-text">Lokasyonunuz :<?php echo getLocation(getUserIP())[0] / getLocation(getUserIP())[1] ?> VPN Kullanıyorsanız giriş yaparken problem yaşabilirsiniz. </p>
                            <?php endif; ?>
                            <?php if(!$result['ip']):?>
                            <button  name="ip" class="btn btn-primary status-active">Aktif Et</button>
                            <?php else: ?>
                            <button  name="dip" class="btn btn-primary status-deactive">Deaktif Et</button>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php
// Veritabanı bağlantısını kurun
$baglan = mysqli_connect("localhost", "root", "", "egenots");

// Bağlantı kontrolü
if (!$baglan) {
    die("Bağlantı hatası: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['guncelle'])) {
    
    $updates = [];
    $username = $_COOKIE['login1']; 

    if (!empty($_POST['email'])) {
        $emaild = htmlspecialchars(trim(stripslashes($_POST['email'])));
        $email = $emaild;
        $updates[] = "email = '$emaild'";
    }

    if (!empty($_POST['dogum'])) {
        $dogumd = htmlspecialchars(trim(stripslashes($_POST['dogum'])));
        $dogum = $dogumd;
        $updates[] = "dogum = '$dogumd'";
    }

    if (!empty($_POST['adres'])) {
        $adresd = htmlspecialchars(trim(stripslashes($_POST['adres'])));
        $adres = $adresd;
        $updates[] = "adres = '$adresd'";
    }

    if (!empty($_POST['telno'])) {
        $telnod = htmlspecialchars(trim(stripslashes($_POST['telno'])));
        $telno = $telnod;
        $updates[] = "telno = '$telnod'";
    }

    if (count($updates) > 0) {

        $updateQuery = "UPDATE auth SET " . implode(", ", $updates) . " WHERE username = '$username'";
        

        if (mysqli_query($baglan, $updateQuery)) {
            echo "<div class='alert alert-success text-center mt-0'>Bilgiler başarıyla güncellendi.</div>";
        } else {
            echo "<div class='alert alert-danger text-center mt-0'>Güncelleme sırasında bir hata meydana geldi: " . mysqli_error($baglan) . "</div>";
        }
    } else {
        echo "<div class='alert alert-warning text-center mt-0'>Güncellenmesi gereken hiçbir bilgi girilmemiş.</div>";
    }


    mysqli_close($baglan);
}
?>

                    </form>
                    <!-- İp Koruması -->
                    <h1 class="text-center mt-3">Hesap Bilgileri</h1>
                    <table class="mt-3">
                    <thead>
                        <tr>
                        <th>Email &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                        <th>Dogum Tarihi &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                        <th>Adres &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                        <th>Telefon Numarası &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                        <th>İp &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                        <td><?php echo $email;?></td>
                        <td><?php echo $dogum;?></td>
                        <td><?php echo $adres;?></td>
                        <td><?php echo $telno;?></td>
                        <td><?php echo $dip;?></td>
                        </tr>
                    </tbody>
                    </table>
                   

                    <form method="POST">
                        <div class="mb-3 mt-3">
                            <label for="exampleInputEmail1" class="form-label">Email</label>
                            <input type="email" value="<?php echo $email;?>" name="email" class="form-control" placeholder="Email" id="exampleInputEmail1" aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="exampleInputEmail1" class="form-label">Doğum Tarihi</label>
                            <input type="date" value="<?php echo $dogum;?>" name="dogum" class="form-control"  id="exampleInputEmail1" aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="exampleInputEmail1" class="form-label">Adres</label>
                            <input type="text" value="<?php echo $adres;?>" name="adres" class="form-control" placeholder="Adres" id="exampleInputEmail1" aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="exampleInputEmail1" class="form-label">Telefon No</label>
                            <input type="Number" value="<?php echo $telno;?>" name="telno" class="form-control" placeholder="Tel No" id="exampleInputEmail1" aria-describedby="emailHelp">
                        </div>
                        <button class="btn btn-primary" name="guncelle">Güncelle</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

