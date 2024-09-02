<?php
session_start();
$baglan = mysqli_connect("localhost","root","","egenots");
$query = "select * from auth where username ='".$_SESSION['login']."';";
$result = mysqli_fetch_assoc(mysqli_query($baglan,$query));
if(!$result['yoneticimi'] || !isset($_SESSION['login'])){
    header("location:../login.php");
}
mysqli_close($baglan);

?>

<?php
require "../bootstrap.php";
$baglan = mysqli_connect("localhost", "root", "", "egenots");

if (!$baglan) {
    die("Bağlantı hatası: " . mysqli_connect_error());
}

// if(!isset($_SESSION['login'])){
//     setcookie("login", 1, time() - 3600);
//     session_destroy();
//     header("Location: ../login.php");
//     exit();
// } else {
//     $username = $_COOKIE['login'];
//     $query = "SELECT * FROM auth WHERE username = ?";
//     $stmt = mysqli_prepare($baglan, $query);
//     mysqli_stmt_bind_param($stmt, "s", $username);
//     mysqli_stmt_execute($stmt);
//     $result = mysqli_stmt_get_result($stmt);
//     $result = mysqli_fetch_assoc($result);

//     if (!$result['yoneticimi']) {
//         header("Location: index.php");
//         exit();
//     }
// }

function deleteLineFromFile($filePath, $lineNumberToDelete) {
    $file = fopen($filePath, "r+");
    if (!$file) {
        echo "Dosya açılamadı.";
        return false;
    }
    
    $lines = [];
    while (($line = fgets($file)) !== false) {
        $lines[] = $line;
    }

    ftruncate($file, 0);
    rewind($file);

    $found = false;
    
    foreach ($lines as $index => $line) {
        if ($index != $lineNumberToDelete) {
            fwrite($file, $line);
        } else {
            $found = true;
        }
    }
    
    fclose($file);
    
    return $found;
}


?>

<?php


if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['kaldir'])){
    $sayi = $_POST['kaldir'];
    deleteLineFromFile("../yenilikler.txt",$sayi);
    header("location:kullanicisec.php");
}
?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['yonet'])) {

        setcookie("login1", $_POST['kullanici'], time() + 3600);
        $_SESSION['login1'] = $_POST['kullanici'];
        $_SESSION['yonetici'] = "";
        header("Location: kullaniciayar/ayarlar.php");
        exit();

}



?>

<?php
                if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['kaldir'])){
                    $baglan = mysqli_connect("localhost","root","","egenots");
                    $query = "delete from banned where id='".$_POST['kaldir']."';";
                    $result = mysqli_query($baglan,$query);
                    mysqli_close($baglan);
                }


                if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['yasak'])){
                    $baglan = mysqli_connect("localhost","root","","egenots");
                    $query = "select * from ip where id='".$_POST['yasak']."';";
                    $result = mysqli_query($baglan,$query);
                    $result = mysqli_fetch_assoc($result);
                    $ip = $result['ip'];
                    $query = "select * from banned where ip='".$ip.".';";
                    $result = mysqli_query($baglan,$query);
                    if($result->num_rows <= 0){
                        echo("sa");
                        $query = "insert into banned(ip) values('".$ip."');";
                        $result = mysqli_query($baglan,$query);
                        header("location:".$_SERVER['PHP_SELF']);

                    }
                    else{
                        header("location:".$_SERVER['PHP_SELF']);
                    }

                    mysqli_close($baglan);
                }

                    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['ekle'])){
                        $baslik = htmlspecialchars(trim(stripslashes($_POST['baslik'])));
                        $yenilik = htmlspecialchars(trim(stripslashes($_POST['yenilik'])));             
                        $myfile = fopen("../yenilikler.txt","a");
                        $str = $baslik."|".Date('j.n.Y')."|".$yenilik."\n";
                        fwrite($myfile,$str);   
                        fclose($myfile);
                        setcookie("ekleme",1,time()+3);
                        header("location:kullaniciayar/ayarlar.php");
                        exit();
                    }

                    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['yasakla'])){
                        $conn = mysqli_connect("localhost","root","","egenots");
                        $query = "update auth set active = '0' where username ='".$_POST['yasaklanacak']."';";
                        $result = mysqli_query($conn,$query);
                        if($result){
                            header("location:".$_SERVER['PHP_SELF']);
                        }
                    }
                    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['yasagikaldir'])){
                        $conn = mysqli_connect("localhost","root","","egenots");
                        $query = "update auth set active = '1' where username ='".$_POST['kaldirilacak']."';";
                        $result = mysqli_query($conn,$query);
                        if($result){
                            header("location:".$_SERVER['PHP_SELF']);
                        }
                    }

                    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['yanit'])) {
                        $yanit = htmlspecialchars(trim(stripslashes($_POST['cevap'])));
                        $id = htmlspecialchars(trim(stripslashes($_POST['yanit']))); 
                        $conn = mysqli_connect("localhost", "root", "", "egenots");
                        $yanit = mysqli_real_escape_string($conn, $yanit);
                        $id = mysqli_real_escape_string($conn, $id);

                        $query = "UPDATE destek SET cozuldumu = '1', cevap = '$yanit' WHERE id = '$id'";
                        echo $query; 

                        $result = mysqli_query($conn, $query);
                    
                        mysqli_close($conn);
                    
                        if ($result) {
                            header("Location: " . $_SERVER['PHP_SELF']);
                            exit(); 
                        } else {
                            echo "Hata: " . mysqli_error($conn);
                        }
                    }

                ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
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
        

        .l {
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }
        .l:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
</style>
<nav class="navbar navbar-expand-lg bg-body-tertiary bg-dark-subtle">
    <div class="container-fluid">
        <img src="../image/egenotes_logo.png" id="logo1" alt="">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
            <a href="../index.php" class="btn btn-primary" name="cik">Yönetici Modundan Çık</a>
            </ul>
        </div>
    </div>
</nav>

<body class="bg-primary-subtle">
    <div class="container">
        <div class="row d-flex justify-content-center mt-3">
            <div class="col-6">
                <div class='alert alert-success mt-0 text-center'>Yönetici Sayfasındasınız.</div>
                <div class='alert alert-danger mt-0 text-center'>Sayfayı Yenilemeyiniz, bu hataya sebep olabilir.</div>

                <h3>Burada seçtiğiniz kullanıcının direkt olarak profiline gidiyor ve istediğiniz işlemi gerçekleştiriyor olacaksınız.</h3>
               <?php
               $baglan1 = mysqli_connect("localhost","root","","egenots");

               $query = "select * from auth;";
               $result = mysqli_query($baglan1,$query);
               ?>
                <form method="POST" id="form">
                        <select class="form-select" name="kullanici">
                            <?php while($row = mysqli_fetch_assoc($result)):?>
                                <option <?php echo 'value ="'.$row['username'].'"';?>><?php echo $row['username'];?></option>
                            <?php endwhile; ?>
                        </select>
                    <button name="yonet" class="btn btn-primary w-100 mt-2">Yönet</button>
                </form>



                <?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['aktif'])) {
        $myfile = fopen("../ayar.txt", "w");
        if ($myfile) {
            fwrite($myfile, "1");
            fclose($myfile);
        } else {
            echo "Dosya açılamadı.";
        }
        header("Location: ".$_SERVER['PHP_SELF']);
        exit;
    }

    if (isset($_POST['deaktif'])) {
        $myfile = fopen("../ayar.txt", "w");
        if ($myfile) {
            fwrite($myfile, "0");
            fclose($myfile);
        } else {
            echo "Dosya açılamadı.";
        }
        header("Location: ".$_SERVER['PHP_SELF']);
        exit;
    }
}
$myfile = fopen("../ayar.txt", "r");
$row = fgets($myfile);
fclose($myfile);
?>

<form method="POST" class="border l rounded-bottom">
<hr>
    <p class="text-center">Bu koruma kullanıcının login olduktan sonra ip adresi değişirse değiştiği ip adresi otomatik olarak yasaklanmasını sağlar.</p>
    <?php if (trim($row) == "1"): ?>
        <button name="deaktif" type="submit" class="btn btn-danger">Korumayı Deaktif Et</button>
    <?php else: ?>
        <button name="aktif" type="submit" class="btn btn-success">Korumayı Aktif Et</button>
    <?php endif; ?>
    <hr>
</form>


                <form method="POST" >
                <h2 class="text-center">Kullanıcı Listesi :</h2>
                <label for="exampleSelect" class="form-label">Yasakla</label>
                    <select name="yasaklanacak" class="form-select" id="exampleSelect">
                        <option selected>Lütfen bir kullanıcı seçin</option>
                        <?php 
                            $conn = mysqli_connect("localhost","root","","egenots");
                            $query = "select * from auth where active = '1';";
                            $result = mysqli_query($baglan,$query);
                        ?>
                        <?php while($row = mysqli_fetch_assoc($result)):?>
                        <option <?php echo 'value ="'.$row['username'].'"';?>><?php echo $row['username'];?></option>
                        <?php endwhile;?>
                    </select>
                    <button name="yasakla" class="btn btn-danger w-100 mt-2">Yasakla</button>

                <label for="exampleSelect" class="form-label">Yasağı Kaldır</label>
                    <select name="kaldirilacak" class="form-select" id="exampleSelect">
                        <option selected>Lütfen bir kullanıcı seçin</option>
                        <?php 
                            $conn = mysqli_connect("localhost","root","","egenots");
                            $query = "select * from auth where active = '0';";
                            $result = mysqli_query($baglan,$query);
                        ?>
                        <?php while($row = mysqli_fetch_assoc($result)):?>
                        <option <?php echo 'value ="'.$row['username'].'"';?>><?php echo $row['username'];?></option>
                        <?php endwhile;?>
                    </select>
                    <button name="yasagikaldir" class="btn btn-success w-100 mt-2">Yasağı Kaldır</button>
                </form>




                <form >

                </form>
                <h2 class="text-center">Yenilikler Sayfasına Yenilik Ekleyin</h2>
                <h5 class="text-center">Eklemek istediğiniz yenilikleri aralarına , koyarak yazınız</h3>


                


                <form method="POST">
                <div class="input-group input-group-sm mb-3">
                    <span  class="input-group-text" id="inputGroup-sizing-sm">Yenilik Başlığı</span>
                    <input name="baslik" require type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                </div>
                    <div class="form-floating">
                        <textarea name="yenilik" class="form-control" placeholder="Eklemek istediğiniz yenilikleri aralarına , koyarak yazınız" id="floatingTextarea2" style="height: 100px"></textarea>
                        <label require for="floatingTextarea2">Eklemek istediğiniz yenilikleri aralarına , koyarak yazınız</label>
                    </div>
                    <button name="ekle" class="w-100 btn btn-primary mt-1">Ekle</button>
                </form>

                <form method="POST">

<?php
$myfile = fopen("../yenilikler.txt", "r");
?>

<div class="container">
    <div class="row">
        <?php while ($satir = fgets($myfile)): ?>
            <?php
            $satir = explode("|", $satir);
            $dizi = explode(",", $satir[2]);
            $sayac = 0;    
            $sayac2 = 0;
            ?>
            <div class="col-md-6 col-lg-6 mb-4">
                <div class="card update-card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($satir[0]); ?></h5>
                        <h6 class="card-subtitle mb-2 text-muted"><?php echo "Tarih : " . htmlspecialchars($satir[1]); ?></h6>
                        <ul class="list-group">
                            <?php foreach ($dizi as $eleman): ?>
                                <li class="list-group-item">Özellik <?php echo ++$sayac . ": " . htmlspecialchars($eleman); ?></li>
                            <?php endforeach; ?>
                            <button name="kaldir" value='<?php echo $sayac2;?>' class='btn btn-primary mt-1'>Kaldır</button>
                        </ul>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<?php
fclose($myfile);
?>
</form>


<?php
$baglan = mysqli_connect("localhost", "root", "", "egenots");

if (!$baglan) {
    die("Bağlantı hatası: " . mysqli_connect_error());
}

if (isset($_POST['yasak'])) {
    $ip = mysqli_real_escape_string($baglan, $_POST['ip']);
    $query = "INSERT INTO banned (ip) VALUES ('$ip')";
    mysqli_query($baglan, $query);
}

$query = "SELECT * FROM ip";
$result = mysqli_query($baglan, $query);

if (!$result) {
    die("Sorgu hatası: " . mysqli_error($baglan));
}
?>

<div class="container mt-5">
    <h1 class="mb-4">IP Listesi</h1>
    <ul class="list-group">
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <?php
            $ip = htmlspecialchars($row['ip']);
            $location = getLocation($ip); 
            $latitude = htmlspecialchars($location[0]);
            $longitude = htmlspecialchars($location[1]);

            $query_banned = "SELECT * FROM banned WHERE ip = '$ip'";
            $result_banned = mysqli_query($baglan, $query_banned);
            $is_banned = mysqli_num_rows($result_banned) > 0;
            ?>
            <li class="list-group-item d-flex justify-content-between align-items-center l">
                <?php echo $ip . " Location: " . $latitude . " / " . $longitude; ?>
                <?php if (!$is_banned): ?>
                <form method="post" class="ml-2">
                    <input type="hidden" name="ip" value="<?php echo $ip; ?>">
                    <button type="submit" name="yasak" value="<?php echo $row['id']; ?>" class="btn btn-danger mt-3">Yasakla</button>
                </form>
                <?php endif; ?>
            </li>
        <?php endwhile; ?>
    </ul>
</div>

<?php
mysqli_close($baglan);
?>




    <div class="container mt-5">
        <h1 class="mb-4">Yasaklı IP Listesi</h1>
        <ul class="list-group">
            <?php
            $baglan = mysqli_connect("localhost", "root", "", "egenots");
            

            
            $query = "SELECT * FROM banned";
            $result = mysqli_query($baglan, $query);
            
            if (!$result) {
                die("Sorgu hatası: " . mysqli_error($baglan));
            }
            
            while($row = mysqli_fetch_assoc($result)):
                $ip = htmlspecialchars($row['ip']);
                $location = getLocation($ip); 
                $latitude = htmlspecialchars($location[0]);
                $longitude = htmlspecialchars($location[1]);
            ?>
                <li class="list-group-item d-flex justify-content-between align-items-center l">
                    <?php echo $ip . " Location: " . $latitude . " / " . $longitude; ?>
                    <form method="post" class="ml-2">
                        <input type="hidden" name="ip" value="<?php echo $ip; ?>">
                        <button type="submit" name="kaldir" value="<?php echo $row['id'];?>" class="btn btn-primary mt-3">Kaldir</button>
                    </form>
                </li>
            <?php endwhile; ?>
        </ul>
    </div>


    <form method="POST">
    <?php
    $baglan = mysqli_connect("localhost", "root", "", "egenots");
    $query = "SELECT * FROM destek WHERE cozuldumu = '0' ORDER BY aciliyet DESC;";
    $result = mysqli_query($baglan, $query);
    mysqli_close($baglan);
    ?>
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <?php if ($row['aciliyet'] == 1): ?>
        <div class="container bg-success mt-3 rounded-bottom">
        <?php elseif ($row['aciliyet'] == 2): ?>
        <div class="container bg-warning mt-3 rounded-bottom">
        <?php else: ?>
        <div class="container bg-danger mt-3 rounded-bottom">
        <?php endif; ?>
            <div class="row">
                <div class="col-6 mt-3">
                    <p><?php echo "<b>" . $row['username'] . "</b><br>" . $row['destek']; ?></p>
                </div>
                <div class="col-6 mt-3">
                    <button name="yanit" value="<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">Yanıtla</button>
                </div>
                <div class="col-12 mt-3 mb-3">
                    <input name="cevap" required class="form-control w-100" type="text">
                </div>
            </div>
        </div>
    <?php endwhile; ?>
</form>



            </div>
        </div>
    </div>
</body>
</html>

<script>

function addFocusEffect(input) {
    input.closest('.l').style.transform = "scale(1.05)";
    input.closest('.l').style.boxShadow = "0 4px 8px rgba(0, 0, 0, 0.2)";
}

function removeFocusEffect(input) {
    input.closest('.l').style.transform = "";
    input.closest('.l').style.boxShadow = "";
}

</script>


