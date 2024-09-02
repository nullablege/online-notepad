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

$sayac = 0;
$username = $_COOKIE['login'];
$baglan = mysqli_connect("localhost","root","","egenots");
$query = "select * from notes where username='".$username."';";
$result = mysqli_query($baglan,$query);

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['kaldir'])){
    $query = "delete from notes where id ='".$_POST['kaldir']."';";
    $result = mysqli_query($baglan,$query);
    if($result){
        echo "<div class='alert alert-success text-center mt-0'>İşlem Başarılı.</div>";
        sleep(1);
        header("location:notlar.php");
    }
    else{
        echo "<div class='alert alert-danger text-center mt-0'>Hata.</div>";
        sleep(1);
        header("location:notlar.php");
    }
}

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['duzenle'])){
    $duzenle = $_POST['duzenle'];
    $query = "select * from notes where id ='".$duzenle."';";
    $result = mysqli_query($baglan,$query);
    $result = mysqli_fetch_assoc($result);
    setcookie("id",$result['id'],time()+3600);
    setcookie("note",$result['note'],time()+3600);
    setcookie("olusturulma",$result['olusturulma'],time()+3600);
    setcookie("guncelleme",$result['guncelleme'],time()+3600); 
    header("location:notduzenle.php");
}

mysqli_close($baglan);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php

    ?>
</head>
<body class="bg-primary-subtle">
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

    .card {
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }
        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .btn-primary, .btn-danger {
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }
</style>


<form method="POST">


<div class="container mt-5">
    <div class="row">

    <?php
    $baglan = mysqli_connect("localhost","root","","egenots");
    $query = "select * from notes where username ='".$username."';";
    $result = mysqli_query($baglan,$query);
    
    ?>

    <?php if($result): ?>
<?php while($row = mysqli_fetch_assoc($result)): ?>
    <?php
        $str = substr($row['note'],0,10);
        $sayac++;
        ?>

        <div class="col-4">
        <div class="card">
            <img src="image/egenotes_logo.png" class="card-img-top" alt="...">
            <div class="card-body">
            <h5 class="card-title text-center"><?php echo $sayac.".Not";?></h5>
            <p class="card-text text-center"><?php echo $str;?></p>
            <div class="container">
                <div class="row">
                    <div class="col-6">
                    <button name="duzenle" value="<?php echo $row['id'];?>" class="btn btn-primary">Notu Düzenle</button>
                    </div>
                    <div class="col-6">
                    <button name="kaldir" value="<?php echo $row['id'];?>" class="btn btn-danger">Notu Kaldır</button>
                    </div>
                </div>
            </div>
            </div>
        </div>
        </div>

        <?php endwhile; ?>
        <?php endif; ?>
<?php
mysqli_close($baglan);
?>
    </div>
    </div>


</form>

</body>
</html>