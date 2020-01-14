<?php
$curl = curl_init();
$url = 'http://nuansamusik.com/category/acoustic-electric-guitars';
$nuansamusik = 'http://nuansamusik.com';
curl_setopt($curl,CURLOPT_URL,$url);
curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);

$result = curl_exec($curl);
$guitar = array();


preg_match_all("!<h4><a href = '.*'>(.*)<\/h4>!",$result,$match);
$list['name']=$match[1];

preg_match_all("!<div class = 'img-container'>.*\D.*<img src = '(.*)' .*>!",$result,$match);
$list['image']=$match[1];


preg_match_all("!<h5><small>Rp.<\/small> (.*)<\/h5>!",$result,$match);
$list['after']=$match[1];
preg_match_all("!<tr class = 'list-price'>.*\D(.*)\D.*!",$result,$match);
$list['before']=$match[1];
$i = 0;
foreach($list['before'] as $hargaawal){
    $hargaExplode = explode(' ',$hargaawal);
    $count = count($hargaExplode)-1;
    $list['before'][$i] = $hargaExplode[$count];
    if($list['before'][$i]==""){
        print_r($list['after'][$i].'</br>');
    }
    else
        print_r($list['before'][$i].' setelah diskon jadi '.$list['after'][$i].'</br>');
    $i++;
}
$guitar = [];
$counter = 0;
curl_close($curl);
?>