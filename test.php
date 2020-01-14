<?php
$curl = curl_init();
$url = 'https://www.melodiamusik.com/product-category/jenis/guitars/electric-guitar?product-page=2';

curl_setopt($curl,CURLOPT_URL,$url);
curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);

$result = curl_exec($curl);
$guitar = array();

preg_match_all('!<h2 class="woocommerce-loop-product__title">(.*?)<\/h2>!',$result,$match);
$guitar['name']=$match[1];


preg_match_all('!<span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">Rp<\/span>&nbsp;(.*?)<\/span>!',$result,$match);
$guitar['price']=$match[1];
print_r($guitar['name'][1]);
?>