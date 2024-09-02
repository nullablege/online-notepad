<?php
session_start();
require_once "bootstrap.php";

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
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php require "navbar.php"?>
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
</head>
<body class="bg-primary-subtle">

<div class="container mt-4">
        <h1 class="text-center mb-4">Güncellemeler ve Yenilikler</h1>
        <div class="row">
            <!-- Güncelleme Kartı Örneği -->
    
            <?php
                $myfile = fopen("yenilikler.txt","r");
            ?>
            <?php while($satir = fgets($myfile)): ?>
                <?php
                $satir = explode("|",$satir);
                $dizi = explode(",",$satir[2]);
                $sayac = 0;    
                ?>
            <div class="col-md-6 col-lg-4">
                <div class="card update-card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $satir[0];?></h5>
                        <h6 class="card-subtitle mb-2 text-muted"><?php echo "Tarih : ". $satir[1];?></h6>
                        <ul class="list-group">
                            <?php foreach ($dizi as $eleman):?>
                            <li class="list-group-item">Özellik <?php echo ++$sayac.": ".$eleman;?></li>
                            <?php endforeach; ?>
                            </ul>
                        </div>
                </div>
            </div>
                <?php endwhile; ?>
            <?php
            fclose($myfile);
            ?>
            


</body>
</html>