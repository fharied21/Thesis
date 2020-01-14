<?php
$curl = curl_init();
$url = 'https://www.melodiamusik.com/product-category/jenis/guitars/electric-guitar?product-page=2';

curl_setopt($curl,CURLOPT_URL,$url);
curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);

$result = curl_exec($curl);
$guitar = array();

preg_match_all('!<span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">Rp<\/span>&nbsp;(.*?)<\/span>!',$result,$match);
$list['price']=$match[1];


preg_match_all('!<a href="(.*?)" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">!',$result,$match);
$list['link']=$match[1];
$guitar = [];
$counter = 0;
curl_close($curl);
foreach($list['link'] as $url){
    $curl = curl_init();

    curl_setopt($curl,CURLOPT_URL,$url);
    curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        
    $result = curl_exec($curl);
    $object = new stdClass();
    preg_match_all('!<h1 class="product_title entry-title">(.*?)<\/h1>!',$result,$match);
    $object->name = $match[1][0];
    $object->price = $list['price'][$counter];
    
    print_r($object->name.' '.$object->price.'</br>');
    array_push($guitar,$object);
    $counter++;
    curl_close($curl);
}
?>