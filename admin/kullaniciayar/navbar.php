<?php
session_start();
$baglan = mysqli_connect("localhost", "root", "", "egenots");
$username = mysqli_real_escape_string($baglan, $_COOKIE['login1']);
$query = "SELECT * FROM auth WHERE username = '$username'";
$result = mysqli_query($baglan, $query);
$result = mysqli_fetch_assoc($result);

 if ($result['ip'] && !($result['ip'] == getUserIP())) {
     setcookie("login", $_COOKIE['login1'], time() - 3600);
     header("Location: login.php");
     exit();
 }
?>
<nav class="navbar navbar-expand-lg bg-body-tertiary bg-dark-subtle">
    <div class="container-fluid">
        <img src="../../image/egenotes_logo.png" id="logo1" alt="">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="notlar.php">Notlarım</a>
                </li>

                
                          <form method="POST">
                          <button class="btn btn-primary" name="cik">Yönetici Modundan Çık</button>
                          </form>

                 
                 

            </ul>
        </div>
    </div>
</nav>

<?php
if(isset($_POST['cik']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
    setcookie("login1",$_COOKIE['login'],time()-3600);
    unset($_SESSION['login1']);
    header("location:../kullanicisec.php");
}

?>



<?php
mysqli_close($baglan);
?>
