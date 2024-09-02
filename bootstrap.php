

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<link rel="icon" href="image/egenotes_logo.png" type="image/png">

<?php

function getUserIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip_address = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip_address = $_SERVER['REMOTE_ADDR'];
    }
    
    return $ip_address;
}

function ban($sec){ 
    $baglan = mysqli_connect("localhost", "root", "", "egenots");
    if (!$baglan) {
        die("Veritabanı bağlantı hatası: " . mysqli_connect_error());
    }

    $ip = mysqli_real_escape_string($baglan, getUserIP());
    
    if ($sec == "banlimi") {
        $query = "SELECT * FROM banned WHERE ip='$ip';";
        $result = mysqli_query($baglan, $query);
        if (!$result) {
            die("Sorgu hatası: " . mysqli_error($baglan));
        }
        if (mysqli_fetch_assoc($result)) {
            mysqli_close($baglan);
            return 1;
        }
        mysqli_close($baglan);
        return 0;
    }

    if ($sec == "banla") {
        $query = "INSERT INTO banned(ip) VALUES('$ip');";
        $result = mysqli_query($baglan, $query);
        if (!$result) {
            die("Sorgu hatası: " . mysqli_error($baglan));
        }
        mysqli_close($baglan);
        return 1;
    }
}


function getLocation($ip){
   $url = "https://ipinfo.io/{$ip}/json";
   $data = file($url);

   $json_string = implode('', $data);
   $parsed_data = json_decode($json_string, true);
   echo "<hr>";
   if($ip == '::1' ){
    $city = "localhost";
    $country = "localhost";
   }
   else{
    $city = $parsed_data['city'];
    $country = $parsed_data['country'];
   }
    return [$city,$country];
}



?>