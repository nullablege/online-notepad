<!-- 1. Bır kullanıcının en fazla acık 3 tane destek bıldırımı olabılır.
2. Cevap kısmı ekle gorevlı bır cevap yollayabılsın.
3. Daha sonrasında bu cevap degıstırılebilir olsun.
4. Daha onceden yollanan aynı baslıklı bır acık destek talebı varsa yollamayı engelle
-- 
ayarlar kısmından guvenlık tedbırlerını ayarla.
username / sıfre degıstırme ozellıgı ekle
ıp adres sınırlaması koymayı ayarla 
lokasyon sınırlaması koymayı ayarla ( apıyle cekerek yapılacak apı yanlıs tespıt edebılır dıye uyarı ekle)
admın panelını ayarlamaya basla. Admın panelıne ıp sınırlaması ekle
admınlerın sayfasından tum kullanıcıların notları gorunebılır olsun. 
admınlerın sayfasından kullanıcı arama ekle aranan kullanıcının paylastıgı notlar / profıl gozukmelı. -->


<?php
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
    setcookie("login",1,time()+3600);
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
   $username = $_COOKIE['login'];
   $tarih = Date('m.d.Y');
   $cozuldumu = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php
    require "navbar.php";
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
    .form-container {
            margin-top: 50px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
        .status-open {
            color: green;
            font-weight: bold;
        }
        .status-closed {
            color: red;
            font-weight: bold;
        }
        .tarih{
            color: purple;
            font-weight: bold;
        }
        .list-group-item {
            border: none;
        }
        .mb-1 span{
            font-weight: bold;
        }

</style>
</head>
<body class="bg-primary-subtle">

<?php
    $baglan = mysqli_connect("localhost","root","","egenots");
if(($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['gonder'])) && !isset($_COOKIE['destek']) ){
    $aciliyet = $_POST['aciliyet'];
    $baslik = htmlspecialchars(trim(stripslashes($_POST['baslik'])));
    $destek = htmlspecialchars(trim(stripslashes($_POST['destek'])));
    setcookie("destek",1,time()+3600);
    $query = "select * from destek where username ='".$username."' and cozuldumu = '"."0';";
    $result = mysqli_query($baglan,$query);
    if(mysqli_num_rows($result)>=3){
        echo "<div class='alert alert-danger mt-0 text-center'>En fazla 3 açık destek talebiniz olabilir.</div>";
    }
    else{
        $query = "insert into destek (username,destek,aciliyet,baslik) VALUES ('".$username."','".$destek."','".$aciliyet."','".$baslik."');";
        $result = mysqli_query($baglan,$query);
        if($result){
            echo "<div class='alert alert-success mt-0 text-center'>Destek talebiniz başarıyla alınmıştır..</div>";
        }
        else{
            echo "<div class='alert alert-danger text-center mt-0'>Destek talebiniz yollanırken bir hata meydana geldi.</div>";
        }
    }
    header("location:destek.php");

}
else{
    echo "<div class='alert alert-danger text-center mt-0'>Yeni bir destek talebi yollamak için gereken zamanın dolmasını bekleyin.</div>";
}
?>

<div class="container form-container">
        <h2 class="text-center mb-4">Destek Talep Formu</h2>
        <form method="post">
           
            <div class="form-group">
                <label for="aciliyet">Aceliyet Derecesi:</label>
                <select class="form-control" id="aciliyet" name="aciliyet" required>
                    <option value="1">1 - En Düşük</option>
                    <option value="2">2 - Orta</option>
                    <option value="3">3 - Acil</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="baslik">Başlık:</label>
                <input require type="text" class="form-control" id="baslik" name="baslik" placeholder="Sorunu kısaca açıklayın" required>
            </div>
            
            <div class="form-group">
                <label for="destek">Destek Açıklaması:</label>
                <textarea require class="form-control" id="destek" name="destek" rows="5" placeholder="Sorunu detaylı bir şekilde açıklayın" required></textarea>
            </div>
            
            <button type="submit" class="btn btn-primary btn-block mt-2" name="gonder">Gönder</button>
        </form>
    </div>


    <div class="container mt-4">
        <h2 class="text-center mb-4">Destek Talepleri</h2>
        <div class="list-group">
            <!-- Destek Talebi 1 -->
            <?php
            $query = "select * from destek where username ='".$username."';";
            $result = mysqli_query($baglan,$query);
            $sayac = 0;
            ?>
            <form method="POST">

            <?php while($row = mysqli_fetch_assoc($result)): ?>
            <a name="sil"  class="list-group-item list-group-item-action">
                <h5 class="mb-1">Başlık <?php echo ++$sayac." : ".$row['baslik'];?></h5>
                <p class="mb-1"><?php echo $row['destek'];?></p>
                <?php if(!empty($row['cevap'])): ?>
                <p class="mb-1"><span>Cevabımız :</span> <?php echo $row['cevap'];?></p>
                <?php endif; ?>
                <?php if(!$row['cozuldumu']):?>
                <small class="status-open">Açık</small>
                <?php else: ?>
                <small class="status-closed">Kapalı</small>
                <?php endif; ?>
                <small class="tarih float-end"><?php echo $row['tarih'];?></small>
                <hr>

                </a>
            <?php endwhile; ?>

            </form>
        </div>
    </div>
    
</body>
</html>


<?php

mysqli_close($baglan);

?>