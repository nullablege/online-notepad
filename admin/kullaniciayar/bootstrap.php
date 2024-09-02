

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

function ban($sec,$ip){
    $baglan = mysqli_connect("localhost","root","","egenots");
    if($sec == "banlimi"){
        #ip banlı mı kontrol et
        $query = "select * from banned where ip='".getUserIP()."';";
        $result = mysqli_query($baglan,$query);
        $result = mysqli_fetch_assoc($result);
        if($result){
            return 1;
        }
        return 0;
    }
    if($sec == "banla"){
        #ip banla
        $query = "insert into banned(ip) values('".$getUserIP()."');";
        $result = mysqli_query($baglan,$query);
        $result = mysqli_fetch_assoc($result);
        if($result){
            return 1;
        }
        return 0;
    }
    mysqli_close($baglan);
}


function getLocation($ip){
   $url = "https://ipinfo.io/{$ip}/json";
   $data = file($url);

   $json_string = implode('', $data);
   $parsed_data = json_decode($json_string, true);
   echo "<hr>";
   $city = $parsed_data['city'];
   $country = $parsed_data['country'];
   
    return [$parsed_data['city'],$parsed_data['country']];
}



?>