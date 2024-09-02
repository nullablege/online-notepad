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
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kayıt Ol</title>
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
    $passwordtekrar = "";
    if(isset($_POST['kaydol']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_COOKIE['register'])){
            echo "<div class='alert alert-danger text-center mb-0'>4 Dakika içerisinde 1 kayit oluşturulabilir.</div>";
            sleep(1);
            header("location:login.php");
        }


        $username = htmlspecialchars(trim(stripslashes($_POST['username'])));
        $password = htmlspecialchars(trim(stripslashes($_POST['password'])));
        $passwordtekrar = htmlspecialchars(trim(stripslashes($_POST['passwordtekrar'])));
        
        $baglan = mysqli_connect("localhost","root","","egenots");
        
        if($password == $passwordtekrar){
            if(strlen($username) >= 4){
                $query = "SELECT * FROM auth WHERE username = '$username';";
                $result = mysqli_query($baglan, $query);
                if(mysqli_num_rows($result) == 0){
                    $hashed = password_hash($password, PASSWORD_DEFAULT);
                    $query = "INSERT INTO auth (username, password) VALUES ('$username', '$hashed');";
                    $result = mysqli_query($baglan, $query);
                    if($result){
                        echo "<div class='alert alert-success text-center mb-0'>Kayıt işlemi başarıyla tamamlandı.</div>";
                        setcookie("register", 1, time() + 240);
                        sleep(1);
                        header("location:login.php");
                        exit();
                    } else {
                        echo "<div class='alert alert-danger text-center mb-0'>Kayıt sırasında problem oluştu.</div>";
                    }
                } else {
                    echo "<div class='alert alert-danger text-center mb-0'>Kullanıcı adı daha önce alınmış.</div>";
                }
            } else {
                echo "<div class='alert alert-danger text-center mb-0'>Kullanıcı adı en az 4 karakterli olmalıdır.</div>";
            }
        } else {
            echo "<div class='alert alert-danger text-center mb-0'>Şifreler uyuşmalıdır.</div>";
        }
        mysqli_close($baglan);
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
                            <input type="text" name="username" class="form-control border-success" id="un" placeholder=" ">
                            <label for="un" class="form-label">Kullanıcı Adı</label>
                        </div>
                        <div class="mb-4 mt-2 input-container">
                            <input type="password" name="password" class="form-control border-success" id="pwd" placeholder=" ">
                            <label for="pwd" class="form-label">Şifre</label>
                        </div>
                        <div class="mb-4 mt-2 input-container">
                            <input type="password" name="passwordtekrar" class="form-control border-success" id="pwdt" placeholder=" ">
                            <label for="pwdt" class="form-label">Şifre Tekrar</label>
                        </div>
                        <div class="container">
                            <div class="row d-flex justify-content-center">
                                <div class="col-6 ">
                                    <button class="btn btn-success w-100" id="btn" name="kaydol" disabled>Kaydol</button>
                                </div>
                        </div>
                    </div>
                </div>
        </div>
    </form>
    <script>
        var pwd = document.getElementById('pwd');
        var pwdt = document.getElementById('pwdt');
        var btn = document.getElementById('btn');
        
        function checkPasswords() {
            if (pwd.value === pwdt.value && pwd.value !== "" && pwdt.value !== "") {
                btn.disabled = false;
            } else {
                btn.disabled = true;
            }
        }
        
        pwd.addEventListener("input", checkPasswords);
        pwdt.addEventListener("input", checkPasswords);
    </script>
</body>
</html>
