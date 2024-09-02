<?php
session_start();
$baglan = mysqli_connect("localhost","root","","egenots");
$query = "select * from auth where username ='".$_SESSION['login']."';";
$result = mysqli_fetch_assoc(mysqli_query($baglan,$query));
if(!$result['yoneticimi']){
    header("location:../login.php");
}
mysqli_close($baglan);

require "bootstrap.php";
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