<?php
    require "bootstrap.php";
    session_start();


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

    if(isset($_COOKIE['register'])){
        echo "<div class='alert alert-danger text-center mb-0'>4 Dakikada 1 Hesap açılabilir.</div>";
        sleep(1);
        header("location:login.php");
        exit();
    }
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
    <title><?php echo "Hosgeldin, ".$_COOKIE['login'];?></title>

</head>
<body class="bg-primary-subtle">
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
<?php require "navbar.php" ?>

<?php
if (($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['kaydet'])) && !empty($_POST['content'])) {
    $baglan = mysqli_connect("localhost","root","","egenots");
    $content = htmlspecialchars(trim(stripslashes($_POST['content'])));
    $username = $_COOKIE['login'];
    $query = "INSERT INTO notes (username, note) VALUES ('$username', '$content')";
    $result = mysqli_query($baglan,$query);
    if($result)
    {
        echo "<div class='alert alert-success text-center mt-0'>Not kaydedildi.</div>";
        sleep(1);
    }
    else{
        echo "<div class='alert alert-danger text-center mt-0'>Hatayla karşılaştık.</div>";
    }
    header("location:notlar.php");
}
?>



<div class="m-2 h-5">
    <form method="POST" id="form1">
        <div class="form-floating">
        <textarea class="form-control" name="content" placeholder="Leave a comment here" id="floatingTextarea"></textarea>
        <label for="floatingTextarea">Notunuzu Giriniz.</label>
        </div>
        <div class="container">
        <div class="row d-flex justify-content-end">
            <div class="col-6 bos">
            </div>
            <div class="col-2 mt-2">
                <button class="btn btn-primary" name="kaydet">Kaydet</button>
            </div>
            <div class="col-2 mt-2">
                <button class="btn btn-danger" id="sifirla">Sıfırla</button>
            </div>
        </div>
    </div>

    </form>
</div>

<script>
    sifirla = document.getElementById('sifirla');
    sifirla.addEventListener('click',()=>{
         document.getElementById('floatingTextarea').value = "";
     })


</script>
    
</body>
</html>