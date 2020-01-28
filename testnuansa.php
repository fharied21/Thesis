<?php
include("connection.php");
ini_set('max_execution_time', 600);

$curl = curl_init();
$url = 'http://nuansamusik.com/category/acoustic-electric-guitars';
curl_setopt($curl,CURLOPT_URL,$url);
curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);

$result = curl_exec($curl);
preg_match_all("!(\d*)<\/a>&nbsp;\D*<a href=\"\?page=\d*\" class=\"next\">Next!",$result,$match);
$loop=$match[1][0];
$counter = 0;
for($i = 1; $i <= $loop ; $i++){
    $curl = curl_init();
    $url = 'http://nuansamusik.com/category/acoustic-electric-guitars?page='.$i;
    $nuansamusik = 'http://nuansamusik.com';
    curl_setopt($curl,CURLOPT_URL,$url);
    curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);

    $result = curl_exec($curl);
    $tipe ='Accoustic Electric Guitar';

    preg_match_all("!<div class = 'img-container'><a href = '(.*)'>!",$result,$match);
    $list['link']=$match[1];
    foreach($list['link'] as $link){       
        if($counter >= 80){
            break;
        }
        $curl2 = curl_init();
        
        $url2 = $nuansamusik.$link;
        curl_setopt($curl2,CURLOPT_URL,$url2);
        curl_setopt($curl2,CURLOPT_RETURNTRANSFER,true);
        
        $result2 = curl_exec($curl2);
        
        preg_match_all("!<div id = 'product-title'>\D*<h1>(.*)<\/h1>!",$result2,$match);
        $name = $match[1][0];
        
        if(stripos($name, 'case') !== false){
            continue;
        }
        
        preg_match_all('!current-rating" style="width:(.\d*)!',$result2,$match);
        $list['rating']=$match[1];
        if(count($list['rating'])>0){
            $rating = floor($match[1][0]/20);
        }else{
            $rating = 0;
        }
        
        preg_match_all("!<small>Rp.<\/small>(.*)<\/h5>!",$result2,$match);
        $list['harga']=$match[1][0];
        preg_match_all("!id=\"image_wrap\">\D*<img src =\D*'(.*)' alt!",$result2,$match);
        $gambar = $match[1][0];
        

        $nameExplode = explode(' ',$name);
        $brand = $nameExplode[0];
        $frets = 24;//default
        $berat = 16;
        $stringHarga = "";
        $hargaExplode = explode('.',$list['harga']);
        foreach($hargaExplode as $harga){
            $stringHarga = $stringHarga.$harga; 
        }
        $gambar = base64_encode(file_get_contents($nuansamusik.$gambar));

        $sql = "INSERT INTO gitar_data (harga_gitar, nama_gitar, brand_gitar,berat_gitar,frets, tipe_gitar, rating, gambar_gitar,link_detail) VALUES 
        ('".$stringHarga."','".$name."', '".$brand."','".$berat."','".$frets."','".$tipe."','".$rating."','".$gambar."','".$url2."')";
        if(mysqli_query($con,$sql)) {
            //echo "success";
        }
        else{
            echo mysqli_error($con);
        }
        curl_close($curl2);

        $counter++;
    }
    if($counter >= 80){
        break;
    }
curl_close($curl);
}



$curl = curl_init();
$url = 'http://nuansamusik.com/category/electric-guitars';
curl_setopt($curl,CURLOPT_URL,$url);
curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);

$result = curl_exec($curl);
preg_match_all("!(\d*)<\/a>&nbsp;\D*<a href=\"\?page=\d*\" class=\"next\">Next!",$result,$match);
$loop=$match[1][0];
$counter = 0;
for($i = 1; $i <= $loop ; $i++){
    $curl = curl_init();
    $url = 'http://nuansamusik.com/category/electric-guitars?page='.$i;
    $nuansamusik = 'http://nuansamusik.com';
    curl_setopt($curl,CURLOPT_URL,$url);
    curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);

    $result = curl_exec($curl);
    $tipe ='Electric Guitar';

    preg_match_all("!<div class = 'img-container'><a href = '(.*)'>!",$result,$match);
    $list['link']=$match[1];
    foreach($list['link'] as $link){       
        if($counter >= 80){
            break;
        }
        $curl2 = curl_init();
        
        $url2 = $nuansamusik.$link;
        curl_setopt($curl2,CURLOPT_URL,$url2);
        curl_setopt($curl2,CURLOPT_RETURNTRANSFER,true);
        
        $result2 = curl_exec($curl2);
        
        preg_match_all("!<div id = 'product-title'>\D*<h1>(.*)<\/h1>!",$result2,$match);
        $name = $match[1][0];
        
        if(stripos($name, 'case') !== false){
            continue;
        }
        
        preg_match_all('!current-rating" style="width:(.\d*)!',$result2,$match);
        $list['rating']=$match[1];
        if(count($list['rating'])>0){
            $rating = floor($match[1][0]/20);
        }else{
            $rating = 0;
        }
        
        preg_match_all("!<small>Rp.<\/small>(.*)<\/h5>!",$result2,$match);
        $list['harga']=$match[1][0];
        preg_match_all("!id=\"image_wrap\">\D*<img src =\D*'(.*)' alt!",$result2,$match);
        $gambar = $match[1][0];
        

        $nameExplode = explode(' ',$name);
        $brand = $nameExplode[0];
        $frets = 19;
        $berat = 16;
        $stringHarga = "";
        $hargaExplode = explode('.',$list['harga']);
        foreach($hargaExplode as $harga){
            $stringHarga = $stringHarga.$harga; 
        }
        $gambar = base64_encode(file_get_contents($nuansamusik.$gambar));

        $sql = "INSERT INTO gitar_data (harga_gitar, nama_gitar, brand_gitar,berat_gitar,frets, tipe_gitar, rating, gambar_gitar,link_detail) VALUES 
        ('".$stringHarga."','".$name."', '".$brand."','".$berat."','".$frets."','".$tipe."','".$rating."','".$gambar."','".$url2."')";
        if(mysqli_query($con,$sql)) {
            //echo "success";
        }
        else{
            echo mysqli_error($con);
        }
        curl_close($curl2);

        $counter++;
    }
    if($counter >= 80){
        break;
    }
curl_close($curl);
}
?>