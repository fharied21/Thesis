<?php
include("connection.php");
include("output.php");

function getAllGuitar($sqlall){
    echo showTable($sqlall);
}

function calculateGuitar($result){
    $minimum = 0;
    $maximum = 100;
//    $price = '';
    $data = [];
    $car_rows = [];
//    $carimage = [];

    while($row=mysqli_fetch_assoc($result)){
        $price = $row['guitar_price'];
        $type = $row['guitar_type'];


        // FUZZIFICATION
        $price_cheap = round(($GLOBALS['pricehigh'] - $price)/($GLOBALS['pricehigh'] - $GLOBALS['pricelow']), 2);
        $price_expensive = round(($price - $GLOBALS['pricelow'])/($GLOBALS['pricehigh'] - $GLOBALS['pricelow']), 2);

        // INFERENCE
        // Fire Strength
        // Price cheap
        $R1 = min($price_cheap, $type);
        $R2 = min($price_expensive, $type);

        //---------------------------------------------------------------------------------//


        //FIND MAX
        $Max1 = max($R1);
        $Max2 = max($R2);
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
        array_push($car_rows, $row);
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
    if($indexcont == 0){
        echo "<script type='text/javascript'>alert('Sorry, no requirement match!')</script>";
        echo "<script language='javascript' type='text/javascript'> location.href='index.html' </script>";
    }else{
        showCalculation($car_rows, $maxindex);
    }
}
?>