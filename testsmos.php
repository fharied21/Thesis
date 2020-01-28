<?php
ini_set('max_execution_time', 600);
$curl = curl_init();
$url = 'https://www.smosyumusic.com/products/category/used-gear/electric-guitar';

curl_setopt($curl,CURLOPT_URL,$url);
curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);

$result = curl_exec($curl);
preg_match_all('!\d*<\/a>\D*<a class="page-next"!',$result,$match);
$loop=1;
if(count($match[1])>0)
    $loop = $match[1][0];

curl_close($curl);
for($i = 1; $i<=$loop ; $i++){
    $curl = curl_init();
    $url = 'https://www.smosyumusic.com/products/category/used-gear/electric-guitar?page='.$i;

    curl_setopt($curl,CURLOPT_URL,$url);
    curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);

    $result = curl_exec($curl);
    preg_match_all('!<div class="product-image">\D*<a href="(.*)">!',$result,$match);
    $list['detail']=$match[1];
    $tipe = 'Electric Guitar';
    foreach($list['detail'] as $detail){
        $curl2 = curl_init();
        $url2 = $detail;

        curl_setopt($curl2,CURLOPT_URL,$url2);
        curl_setopt($curl2,CURLOPT_RETURNTRANSFER,true);

        $result2 = curl_exec($curl2);
        preg_match_all('!<title>(.*)<\/title>!',$result2,$match);
        $name=$match[1][0];
        $nameExplode = explode(' ',$name);
        $brand = $nameExplode[0];
        preg_match_all('!IDR (.*).00!',$result2,$match);
        $harga=$match[1][1];    
        
        preg_match_all('!Frets\D*(\d*)!',$result2,$match);
        $list['frets']=$match[1];
        $frets = 24;//set default dulu
        foreach($match[1] as $mungkinfrets){
            if($mungkinfrets>15)
                $frets = $mungkinfrets;        
        }
        $rating = 3;//default
        $berat = 16;//default
        preg_match_all('!<img class="product-img-main" src="(.*)" alt!',$result2,$match);
        $linkGambar=$match[1][0];
        $gambar = base64_encode(file_get_contents($linkGambar));

        $sql = "INSERT INTO gitar_data (harga_gitar, nama_gitar, brand_gitar,berat_gitar,frets, tipe_gitar, rating, gambar_gitar,link_detail) VALUES 
        ('".$stringHarga."','".$name."', '".$brand."','".$berat."','".$frets."','".$tipe."','".$rating."','".$gambar."','".$url2."')";
        if(mysqli_query($con,$sql)) {
            //echo "success";
        }
        else{
            echo mysqli_error($con);
        }
        curl_close($curl2);
    }
    curl_close($curl);
}



$curl = curl_init();
$url = 'https://www.smosyumusic.com/products/category/used-gear/acoustic-guitar';

curl_setopt($curl,CURLOPT_URL,$url);
curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);

$result = curl_exec($curl);
preg_match_all('!\d*<\/a>\D*<a class="page-next"!',$result,$match);
$loop=1;
if(count($match[1])>0)
    $loop = $match[1][0];

curl_close($curl);
for($i = 1; $i<=$loop ; $i++){
    $curl = curl_init();
    $url = 'https://www.smosyumusic.com/products/category/used-gear/acoustic-guitar?page='.$i;

    curl_setopt($curl,CURLOPT_URL,$url);
    curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);

    $result = curl_exec($curl);
    preg_match_all('!<div class="product-image">\D*<a href="(.*)">!',$result,$match);
    $list['detail']=$match[1];
    $tipe = 'Accoustic Electric Guitar';
    foreach($list['detail'] as $detail){
        $curl2 = curl_init();
        $url2 = $detail;

        curl_setopt($curl2,CURLOPT_URL,$url2);
        curl_setopt($curl2,CURLOPT_RETURNTRANSFER,true);

        $result2 = curl_exec($curl2);
        preg_match_all('!<title>(.*)<\/title>!',$result2,$match);
        $name=$match[1][0];
        $nameExplode = explode(' ',$name);
        $brand = $nameExplode[0];
        preg_match_all('!IDR (.*).00!',$result2,$match);
        $harga=$match[1][1];    
        
        preg_match_all('!Frets\D*(\d*)!',$result2,$match);
        $list['frets']=$match[1];
        $frets = 19;//set default dulu
        foreach($match[1] as $mungkinfrets){
            if($mungkinfrets>15)
                $frets = $mungkinfrets;        
        }
        $rating = 3;//default
        $berat = 16;//default
        preg_match_all('!<img class="product-img-main" src="(.*)" alt!',$result2,$match);
        $linkGambar=$match[1][0];
        $gambar = base64_encode(file_get_contents($linkGambar));

        $sql = "INSERT INTO gitar_data (harga_gitar, nama_gitar, brand_gitar,berat_gitar,frets, tipe_gitar, rating, gambar_gitar,link_detail) VALUES 
        ('".$stringHarga."','".$name."', '".$brand."','".$berat."','".$frets."','".$tipe."','".$rating."','".$gambar."','".$url2."')";
        if(mysqli_query($con,$sql)) {
            //echo "success";
        }
        else{
            echo mysqli_error($con);
        }
        curl_close($curl2);
    }
    curl_close($curl); 
} 
?>