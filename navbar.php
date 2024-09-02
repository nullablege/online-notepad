<?php
$baglan = mysqli_connect("localhost","root","","egenots");
$query = "select * from auth where username ='".$_COOKIE['login']."';";
$result = mysqli_query($baglan,$query);
$result = mysqli_fetch_assoc($result);
if($result['ip'] && !($result['ip'] == getUserIP())){
    setcookie("login",$_COOKIE['login'],time()-3600);
    header("location:login.php");
}

?>

<nav class="navbar navbar-expand-lg bg-body-tertiary bg-dark-subtle ">
  <div class="container-fluid">
    <img src="image/egenotes_logo.png" id="logo1" alt="">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="notlar.php">Notlarım</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="yenilikler.php">Yenilikler</a>
        </li>
        <li class="nav-item">
          <a class="nav-link disabled" href="premium.php" >Premium</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
           <?php echo $_COOKIE['login'];?>
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="ayarlar.php">Ayarlar</a></li>
            <li><a class="dropdown-item" href="destek.php">Destek</a></li>
            <li><a class="dropdown-item" href="logout.php">Çıkış Yap</a></li>
            <?php if($result['yoneticimi']):?>
              <li><a class="dropdown-item" href="admin/kullanicisec.php">Yönetici</a></li>
            <?php endif; ?>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>



<script>
    logo = document.getElementById('logo1');
    logo1.addEventListener('click',()=>{
        window.location = "index.php";
    })
</script>

<?php
mysqli_close($baglan);
?>