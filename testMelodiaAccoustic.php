<?php
ini_set('max_execution_time', 300);
$curl = curl_init();
$url = 'https://www.melodiamusik.com/product-category/jenis/guitars/acoustic-electric-guitar';

curl_setopt($curl,CURLOPT_URL,$url);
curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);

$result = curl_exec($curl);



preg_match_all('!(\d*)<\/a><\/li>\D*<li><a class="next page-numbers"!',$result,$match);
$loop=$match[1][0];

curl_close($curl);
for($i = 1; $i <= $loop ; $i++){
    
    $curl = curl_init();
    $url = 'https://www.melodiamusik.com/product-category/jenis/guitars/acoustic-electric-guitar?product-page='.$i;

    curl_setopt($curl,CURLOPT_URL,$url);
    curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);

    $result = curl_exec($curl);
    preg_match_all('!<span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">Rp<\/span>&nbsp;(.*?)<\/span>!',$result,$match);
    $list['price']=$match[1];


    preg_match_all('!<a href="(.*?)" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">!',$result,$match);
    $list['link']=$match[1];
    $counter = 0;
    curl_close($curl);
    foreach($list['link'] as $url2){
        $curl2 = curl_init();

        curl_setopt($curl2,CURLOPT_URL,$url2);
        curl_setopt($curl2,CURLOPT_RETURNTRANSFER,true);
        
        $result2 = curl_exec($curl2);
        preg_match_all('!<h1 class="product_title entry-title">(.*?)<\/h1>!',$result2,$match);
        $list['name']=$match[1];
        preg_match_all('!Frets\D*(\d*)!',$result2,$match);
        if(count($match[1])>0){
            $isValid = 0;
            foreach($match[1] as $frets){
                if($frets>15){
                    $list['frets']=$frets;
                    $isValid = 1;
                }
            }
            if($isValid == 0)        
                $list['frets'] = 24;
        }
        else
        $list['frets'] = 24;
        preg_match_all('!<th class="woocommerce-product-attributes-item__label">Weight<\/th>\D*<td class="woocommerce-product-attributes-item__value">(\d*)!',$result2,$match);
        $berat = $match[1][0];
        preg_match_all('!Brand:\D*>(.*)<\/a><!',$result2,$match);
        $brand = $match[1][0];
        print_r($list['name'][0].' '.$brand.' '.$list['price'][$counter]. ' '.$list['frets'].' '.$berat.' kg <br>');
        $counter++;
        curl_close($curl2);
    }
}
?>