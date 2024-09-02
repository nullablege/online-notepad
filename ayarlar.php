<?php
require "navbar.php";
session_start();
require "bootstrap.php";

$baglan = mysqli_connect("localhost", "root", "", "egenots");
$ip = mysqli_real_escape_string($baglan, getUserIP());
$query = "SELECT * FROM ip WHERE ip = '$ip'";
$result = mysqli_query($baglan, $query);
$banla = 0;
$myfile = fopen("ayar.txt","r");
$row = fgets($myfile);
if($row == 1){
    $banla = 1;
}
fclose($myfile);
if ($result && !(mysqli_num_rows($result) > 0)) {
    if(isset($_COOKIE['login']) && $banla){
            if(!ban('banlimi')){
                $query = "insert into ip(ip) values('".$ip."');";
                $result = mysqli_query($baglan,$query);
                ban('banla');
            }
        exit();
    }
    else{
        $query = "insert into ip(ip) values('".$ip."');";
        $result = mysqli_query($baglan,$query);
        exit();
    }
}
mysqli_close($baglan);


$baglan = mysqli_connect("localhost", "root", "", "egenots");
$ip = mysqli_real_escape_string($baglan, getUserIP());
$query = "SELECT * FROM banned WHERE ip = '$ip'";
$result = mysqli_query($baglan, $query);
if ($result && mysqli_num_rows($result) > 0) {
    session_destroy();
    setcookie("login", "", time() - 3600, "/"); 
    header("Location: login.php");
    exit();
}
mysqli_close($baglan);

if(!isset($_COOKIE['login']) || !isset($_SESSION['login'])){
    setcookie("login",1,time()-3600);
    session_destroy();
    header("location:login.php");
   }
else{
    $baglan = mysqli_connect("localhost","root","","egenots");
    $query = "select * from auth where username='".$_COOKIE['login']."';";
    $result = mysqli_fetch_assoc(mysqli_query($baglan,$query));
    if(!$result['active']){
        header("location:login.php");
        setcookie("yasakli","1",time()+3600);
        setcookie("login",1,time()-3600);
        session_destroy();
    }
    mysqli_close($baglan);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php

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
    $mevcutsifre = htmlspecialchars(trim(stripslashes($_POST['msifre'])));
    $yenisifre1 = htmlspecialchars(trim(stripslashes($_POST['ysifre1'])));
    $yenisifre2 = htmlspecialchars(trim(stripslashes($_POST['ysifre2'])));
    $baglan = mysqli_connect("localhost","root","","egenots");
    $username = $_COOKIE['login'];
    $query = "select * from auth where username ='".$username."';";
    $result = mysqli_query($baglan,$query);
    if($result){
        $result = mysqli_fetch_assoc($result);
        if(password_verify($mevcutsifre,$result['password'])){
            if($yenisifre1 == $yenisifre2){
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
            else{
                echo "<div class='alert alert-danger text-center mt-0'>Yeni şifreler uyuşmalıdır.</div>";
            }
        }
        else{
            echo "<div class='alert alert-danger text-center mt-0'>Mevcut şifre hatalı.</div>";
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
                    <form method="POST">
                        <div class="form-group mt-2">
                            <label for="exampleInputEmail1">Mevcut Şifreniz :</label>
                            <input type="password" name="msifre" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Eski Şifreyi Giriniz.">
                        </div>
                        <div class="form-group mt-2">
                            <label for="exampleInputPassword1">Yeni Şifreniz :</label>
                            <input type="password" name="ysifre1" class="form-control" id="exampleInputPassword1" placeholder="Yeni Şifreyi Giriniz.">
                        </div>
                        <div class="form-group mt-2">
                            <label for="exampleInputPassword1">Yeni Şifreniz :</label>
                            <input type="password" name="ysifre2" class="form-control" id="exampleInputPassword1" placeholder="Yeni Şifreyi Giriniz.">
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
                        $query = "UPDATE auth SET ip ='".$ip."' where username ='".$_COOKIE['login']."';";
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
                        $query = "UPDATE auth SET ip ='' where username ='".$_COOKIE['login']."';";
                        $result = mysqli_query($baglan,$query);
                        if($result){
                            echo "<div class='alert alert-success text-center mt-0'>İşlem başarılı</div>";
                        }
                        else{
                            echo "<div class='alert alert-danger text-center mt-0'>İşlem sırasında hata.</div>";
                        }
                        header("location:ayarlar.php");
                    }

                    
                    $query = "select * from auth where username ='".$_COOKIE['login']."';";
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
$baglan = mysqli_connect("localhost", "root", "", "egenots");

if (!$baglan) {
    die("Bağlantı hatası: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['guncelle'])) {
    
    $updates = [];
    $username = $_COOKIE['login']; 

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

