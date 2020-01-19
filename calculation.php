<?php
include("connection.php");
$sql = "SELECT * FROM gitar_data where harga_diskon >='". $_POST['pricelow']. "'and harga_diskon <= '".$_POST['pricehigh']."'";
$result = $con->query($sql); //koneksi ke database (connection executes query)
calculateGuitar($result);

function calculateGuitar($result){
    $min_discount = 0;
    $max_discount = 100;
    $minimum = 0;
    $maximum = 100;
    $price_high = 100;
    $price_low = 1;
    $data = [];
    $gitar_row = [];

    while($row=mysqli_fetch_assoc($result)){
        $price = round(($row['harga_gitar']/1000000),2);
        $discount = round((($row['harga_gitar'] - $row['harga_diskon'])/$row['harga_gitar']),2);
        //$type = $row['guitar_type'];


        // FUZZIFICATION
        $price_cheap = round(($price_high - $price)/($price_high - $price_low), 2);
        $price_expensive = round(($price - $price_low)/($price_high - $price_low), 2);
        $discount_low = round(($max_discount - $discount)/($max_discount - $min_discount), 2);
        $discount_high = round(($discount - $min_discount)/($max_discount - $min_discount), 2);



        // INFERENCE
        // Fire Strength
        // Price cheap
        $R1 = min($price_cheap, $discount_low);
        $R2 = min($price_cheap, $discount_high);
        
        $R3 = min($price_expensive, $discount_low);
        $R4 = min($price_expensive, $discount_high);
        //---------------------------------------------------------------------------------//


        //FIND MAX
        $Max1 = max($R1,$R2);
        $Max2 = max($R3,$R4);
        $Max = max($Max1, $Max2);

        //FIND a1 AND DEFUZZIFICATION
        if($Max1 > $Max2){
            //FIND a1
            $a1 = $maximum - ($Max1 * ($maximum - $minimum)); // a1 = domain
            //FIND DEFFUZIFICATION
            $MOM = ($minimum + $a1) / 2;
        }else if($Max1 < $Max2){
            //FIND a1
            $a1 = $minimum + ($Max2 * ($maximum - $minimum)); // a1 = domain
            //FIND DEFFUZIFICATION
            $MOM = ($a1 + $maximum) / 2;
        }else{
            //FIND a1
            $a1 = ($minimum + $maximum) / 2; // a1 = domain
            //FIND DEFFUZIFICATION
            $MOM = $a1;
        }
        array_push($data, $MOM);
        array_push($gitar_row, $row);
//        array_push($carimage,$row);
    }
    $highest = 0;
    $indexcont = 0;
    $maxindex = 0;
    
    foreach ($data as $value){
        if($highest < $value){
            $highest = $value;
            $maxindex = $indexcont;
        }
        $indexcont+=1;
    }
    echo $indexcont .' '. $maxindex;
include("output.php");
}
?>