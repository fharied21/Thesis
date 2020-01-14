<?php
include("connection.php");
$curl = curl_init();
$url = 'http://nuansamusik.com/category/acoustic-electric-guitars';
$nuansamusik = 'http://nuansamusik.com';
curl_setopt($curl,CURLOPT_URL,$url);
curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);

$result = curl_exec($curl);
$guitar = array();
$tipe ='acoustic-electric-guitars';

preg_match_all("!<h4><a href = '.*'>(.*)<\/a><\/h4>!",$result,$match);
$list['name']=$match[1];

preg_match_all("!<h4><a href = '.*'>(\w*) !",$result,$match);
$list['brand']=$match[1];
preg_match_all("!<div class = 'img-container'>.*\D.*<img src = '(.*)' .*>!",$result,$match);
$list['image']=$match[1];

preg_match_all("!<h5><small>Rp.<\/small> (.*)<\/h5>!",$result,$match);
$list['after']=$match[1];
preg_match_all("!<tr class = 'list-price'>.*\D(.*)\D*<\/td>\D*<\/tr>!",$result,$match);
$list['before']=$match[1];
$i = 0;
foreach($list['before'] as $hargaawal){
    $hargaExplode = explode(' ',$hargaawal);
    $count = count($hargaExplode)-1;
    $list['before'][$i] = $hargaExplode[$count];
    
    $stringHarga1 = ""; //ini untuk before
    $stringHarga2 = ""; //ini untuk after
    $hargaExplode = explode('.',$list['after'][$i]);
    foreach($hargaExplode as $harga){
        $stringHarga2 = $stringHarga2.$harga; 
    }
    if($list['before'][$i]==""){
        $stringHarga1 = $stringHarga2;
        //print_r($list['after'][$i].'</br>');
    }
    else{
        $hargaExplode = explode('.',$list['before'][$i]);
        foreach($hargaExplode as $harga){
            $stringHarga1 = $stringHarga1.$harga; 
        }
        //print_r($list['before'][$i].' setelah diskon jadi '.$list['after'][$i].' '.((int)$stringHarga1)-((int)$stringHarga2).'</br>');
    } 
    $gambar = base64_encode(file_get_contents($nuansamusik.$list['image'][$i]));
    $sql = "INSERT INTO gitar_data (harga_gitar,harga_diskon, nama_gitar, brand_gitar, tipe_gitar, gambar_gitar) VALUES 
    ('".$stringHarga1."','".$stringHarga2."','".$list['name'][$i]."', '".$list['brand'][$i]."','".$tipe."','".$gambar."')";
    if(mysqli_query($con,$sql)) {
        echo "success";
    }
    else{
        echo mysqli_error($con);
    }
    $i++;
    
}
$guitar = [];
$counter = 0;
curl_close($curl);
?>