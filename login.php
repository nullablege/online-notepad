<?php
   require "bootstrap.php";
   session_start();


   $baglan = mysqli_connect("localhost", "root", "", "egenots");
   $ip = mysqli_real_escape_string($baglan, getUserIP());
   $query = "SELECT * FROM ip WHERE ip = '$ip'";
   $result = mysqli_query($baglan, $query);
   if ($result && !(mysqli_num_rows($result) > 0)) {
           $query = "insert into ip(ip) values('".$ip."');";
           $result = mysqli_query($baglan,$query);
           exit();
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

   if(isset($_COOKIE['login']) && isset($_SESSION['login'])){
    header("location:index.php");
   }
   if(isset($_COOKIE['logout'])){
        echo '<div class="alert alert-warning text-center mt-0">Başarıyla Çıkış Yapıldı</div>';
   }
   if(isset($_COOKIE['cpassword'])){
    echo '<div class="alert alert-warning text-center mt-0">Şifre değişikliği sebebiyle giriş yapınız.</div>';
   }
   if(ban("banlimi")){
    header("location:https://www.google.com");
        
   }
   
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles.css"> 
    <style>
body {
    font-family: Arial, sans-serif;
}

.input-container {
    position: relative;
    margin-bottom: 20px; 
}

input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    outline: none;
    font-size: 16px;
    background-color: #fff; 
}

.form-label {
    position: absolute;
    top: 10px;
    left: 10px;
    pointer-events: none;
    transition: all 0.3s ease;
    font-size: 16px;
    color: #666;
    background-color: #f8f9fa; 
    padding: 0 4px;
    border-radius: 4px; 
}

input:focus + .form-label,
input:not(:placeholder-shown) + .form-label {
    top: -10px;
    left: 10px;
    font-size: 12px;
    color: black;
    background-color: none;
}
    </style>

<?php
$username = "";
$password = "";



if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['giris'])){
    $username = htmlspecialchars(trim(stripslashes($_POST['username'])));
    $password = htmlspecialchars(trim(stripslashes($_POST['password'])));
    $ip = getUserIP();
    $baglan = mysqli_connect("localhost","root","","egenots");
    $query = "select * from auth where username ='".$username."';";
    $result = mysqli_query($baglan,$query);
    $result = mysqli_fetch_assoc($result);

    if($result['active']){
        if(isset($_COOKIE['banli'])){
            $username = "";
            $password = "";
        }
        if(!$result['ip']){
            if(password_verify($password,$result['password'])){
                if($result['active']){
                    setcookie("login",$username,time()+3600);
                    $_SESSION['login'] = $username;
                    echo "<div class='alert alert-primary mt-0 text-center'>Giriş Başarılı, aktarılıyorsunuz.</div>";
                    sleep(1);
                    header("location:index.php");
                }
                else{
                    echo "<div class='alert alert-success text-center mt-0'>Hesap aktif değil.</div>";
                }
            }
            else{
                echo "<div class='alert alert-danger text-center mt-0'>Toplam 3 deneme hakkınız vardır, 3 den sonra ip adresiniz yasaklanacaktır.</div>";
                if(isset($_COOKIE['uyari1'])){
                    if(isset($_COOKIE['uyari2'])){
                        if(isset($_COOKIE['uyari3'])){
                            #ban("banla",$ip);
                            #Sunucu açıldığı zaman aç
                        }
                        else{
                            setcookie("uyari3",1,time()+3600);
                        }
                    }
                    else{
                        setcookie("uyari2",1,time()+3600);
                    }
                }
                else{
                    setcookie("uyari1",1,time()+3600);
                }
            }
        }
        else{
            if($result['ip'] == $ip){
                if(password_verify($password,$result['password'])){
                    if($result['active']){
                        setcookie("login",$username,time()+3600);
                        $_SESSION['login'] = $username;
                        echo "<div class='alert alert-primary mt-0 text-center'>Giriş Başarılı, aktarılıyorsunuz.</div>";
                        sleep(1);
                        header("location:index.php");
                    }
                    else{
                        echo "<div class='alert alert-success text-center mt-0'>Hesap aktif değil.</div>";
                    }
                }
                else{
                    echo "<div class='alert alert-danger text-center mt-0'>Toplam 3 deneme hakkınız vardır, 3 den sonra ip adresiniz yasaklanacaktır.</div>";
                    if(isset($_COOKIE['uyari1'])){
                        if(isset($_COOKIE['uyari2'])){
                            if(isset($_COOKIE['uyari3'])){
                                ban("banla",$ip);
                            }
                            else{
                                setcookie("uyari3",1,time()+3600);
                            }
                        }
                        else{
                            setcookie("uyari2",1,time()+3600);
                        }
                    }
                    else{
                        setcookie("uyari1",1,time()+3600);
                    }
    
                }
            }
            else{
                echo "<div class='alert alert-danger text-center mt-0'>İp sınırlaması olan hesaba giriş denemesinde bulundunuz, hesap sahibi konu hakkında bilgilendirilmiştir.</div>";
                if(isset($_COOKIE['uyari1'])){
                    if(isset($_COOKIE['uyari2'])){
                        if(isset($_COOKIE['uyari3'])){
                            ban("banla",$ip);
                        }
                        else{
                            setcookie("uyari3",1,time()+3600);
                        }
                    }
                    else{
                        setcookie("uyari2",1,time()+3600);
                    }
                }
                else{
                    setcookie("uyari1",1,time()+3600);
                }
            }
        }
    }
    else{
        echo "<div class='alert alert-danger text-center mt-0'>Hesap deaktif edilmiş.</div>";
        #buraya active olmayan hesaba gırmeye calısan hesap banlanmak ıstenırse ekleme yapılabılır.
    }
    mysqli_close($baglan);
}

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['kaydol'])){
    header("location:register.php");
}

?>
</head>
<body class="bg-success-subtle">
    <form method="POST">
        <div class="container">
                <div class="row d-flex justify-content-center mt-5">
                    <div class="col-6">
                        <div class="container">
                            <div class="row d-flex justify-content-center">
                                <img src="image/egenotes_logo.png" alt="">
                            </div>
                        </div>
                        <div class="mb-4 mt-2 input-container">
                            <input type="text" <?php if(isset($_COOKIE['banli'])) echo "disabled";?> name="username" class="form-control border-success" id="un" placeholder=" ">
                            <label for="emailInput1"  class="form-label">Kullanıcı Adı </label>
                        </div>
                        <div class="mb-4 mt-2 input-container">
                            <input type="password" <?php if(isset($_COOKIE['banli'])) echo "disabled";?> name="password" class="form-control border-success" id="pwd" placeholder=" " disabled="True">
                            <label for="emailInput2"  class="form-label">Şifre </label>
                        </div>
                        <div class="container">
                            <div class="row d-flex justify-content-center">
                                <div class="col-6 ">
                                    <button <?php if(isset($_COOKIE['banli'])) echo "disabled";?> class="btn btn-success w-100" name="giris">Giriş Yap</button>
                                </div>
                                <div class="col-6 ">
                                    <button <?php if(isset($_COOKIE['banli'])) echo "disabled";?> class="btn btn-primary w-100" name="kaydol">Kaydol</button>
                                </div>
                        </div>
                    </div>
                </div>
        </div>
    </form>
    <script>
        var password = document.getElementById('pwd');
        var username = document.getElementById('un');

        username.addEventListener("change", () => {
            password.disabled = false;
        });
    </script>
</body>
</html>
