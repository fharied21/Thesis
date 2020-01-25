<?php
$curl = curl_init();
$url = 'https://www.smosyumusic.com/products/category/used-gear/electric-guitar';

curl_setopt($curl,CURLOPT_URL,$url);
curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);

$result = curl_exec($curl);


preg_match_all('!<div class="product-name">\D*\S*">(.*)<\/a>!',$result,$match);
$list['name']=$match[1];
preg_match_all('!<div class="product-price">\D*(.*)!',$result,$match);
$list['price']=$match[1];
preg_match_all('!<div class="product-image">\D*<a href="(.*)">!',$result,$match);
$list['detail']=$match[1];
preg_match_all('!<div class="product-image">\D*<a href="\S*"><img src="(.*)"!',$result,$match);
$list['image']=$match[1];
$c = 0;
foreach($list['detail'] as $detail){
    $curl2 = curl_init();
    $url2 = $detail;

    curl_setopt($curl2,CURLOPT_URL,$url2);
    curl_setopt($curl2,CURLOPT_RETURNTRANSFER,true);

    $result2 = curl_exec($curl2);
    preg_match_all('!Frets\D*(\d*)!',$result2,$match);
    $list['frets']=$match[1];
    foreach($match[1] as $fret){
        if($fret>15)
            print_r($list['name'][$c].', jumlah frets : '.$fret);
    }
    $c++;
}
?>