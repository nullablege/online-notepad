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

$id = $_COOKIE['id'] ?? '';
$note = $_COOKIE['note'] ?? '';
$olusturulma = $_COOKIE['olusturulma'] ?? '';
$guncelleme = $_COOKIE['guncelleme'] ?? '';


if (!$id || !$note || !$olusturulma || !$guncelleme) {
    header("location:notlar.php");
    exit();
}

$baglan = mysqli_connect("localhost", "root", "", "egenots");
if (!$baglan) {
    die("Veritabanı bağlantısı başarısız: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['kaydet'])) {
    $content = htmlspecialchars(trim(stripslashes($_POST['content'])));
    
    $query = "UPDATE notes SET note = ?, olusturulma = ? WHERE id = ?";
    $stmt = $baglan->prepare($query);
    
    if (!$stmt) {
        die('MySQL prepare error: ' . $baglan->error);
    }

    $stmt->bind_param("ssi", $content, $olusturulma, $id);

    if ($stmt->execute()) {
        echo '<div class="alert alert-success text-center mt-0">Kayıt işlemi başarılı.</div>';
        sleep(1);
        setcookie("id", "", time() - 3600, "/"); 
        setcookie("note", "", time() - 3600, "/");
        setcookie("olusturulma", "", time() - 3600, "/");
        setcookie("guncelleme", "", time() - 3600, "/");
        header("location:notlar.php");
        exit();
    } else {
        echo '<div class="alert alert-danger text-center mt-0">Hata: ' . $stmt->error . '</div>';
    }

    $stmt->close();
    mysqli_close($baglan);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo "Hoşgeldin, " . htmlspecialchars($_COOKIE['login']); ?></title>
</head>
<body class="bg-primary-subtle">
<style>
    #logo1 {
        max-width: 150px;
    }
    #floatingTextarea {
        height: 80%;
        resize: none;
    }
    .bos {
        min-width: 100%;
    }
    .btn {
        width: 100%;
    }
</style>
<?php require "navbar.php"; ?>

<div class="m-2 h-5">
    <form method="POST" id="form1">
        <div class="form-floating">
            <textarea class="form-control" name="content" placeholder="Leave a comment here" id="floatingTextarea"><?php echo htmlspecialchars($note); ?></textarea>
            <label for="floatingTextarea">Notunuzu Giriniz.</label>
        </div>
        <div class="container">
            <div class="row d-flex justify-content-end">
                <div class="col-6 bos"></div>
                <div class="col-2 mt-2">
                    <button class="btn btn-primary" name="kaydet">Kaydet</button>
                </div>
                <div class="col-2 mt-2">
                    <button class="btn btn-danger" type="button" id="sifirla">Sıfırla</button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    document.getElementById('sifirla').addEventListener('click', () => {
        document.getElementById('floatingTextarea').value = "";
    });
</script>
</body>
</html>
