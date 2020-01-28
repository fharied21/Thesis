<?php
include("connection.php");
$sql = "SELECT * FROM gitar_data where true";
if(!($_POST['guitarType'] == ""))
    $sql = "SELECT * FROM gitar_data where tipe_gitar = '".$_POST['guitarType']."'";
    $sql =  $sql." and harga_gitar >= ". $_POST['pricelow'];
    $sql =  $sql." and harga_gitar <= ".$_POST['pricehigh'];
    $sql =  $sql." and rating >= ". $_POST['lowrate'];
    $sql =  $sql." and rating <= ".$_POST['highrate'];
    $sql =  $sql." and frets >= ". $_POST['fretlow'];
    $sql =  $sql." and frets <= ".$_POST['frethigh'];
    $sql =  $sql." and berat_gitar >= ". $_POST['lightest'];
    $sql =  $sql." and berat_gitar <= ".$_POST['heaviest'];

    
$result = $con->query($sql); //koneksi ke database (connection executes query)
calculateGuitar($result);

function calculateGuitar($result){
    $minimum = 0;
    $maximum = 100;
    $price_high = 100;
    $price_low = 1;
    $light_gitar = 4;//in kg 
    $heavy_gitar = 20;//in kg 
    $low_frets = 10; 
    $many_frets = 30; 
    $data = [];
    $gitar_row = [];
    
    while($row=mysqli_fetch_assoc($result)){
        $price = round(($row['harga_gitar']/1000000),2);

        // FUZZIFICATION
        $price_cheap = round(($price_high - $price)/($price_high - $price_low), 2);
        $price_expensive = round(($price - $price_low)/($price_high - $price_low), 2);
        $not_heavy = round(($heavy_gitar - $row['berat_gitar'])/($heavy_gitar - $light_gitar), 2);
        $heavy = round(($row['berat_gitar'] - $light_gitar)/($heavy_gitar - $light_gitar), 2);
        $minimum_frets = round(($many_frets - $row['frets'])/($many_frets - $low_frets), 2);
        $maximum_frets = round(($row['frets'] - $low_frets)/($many_frets - $low_frets), 2);
        
        

        // INFERENCE
        // Price cheap,not too heavy, many frets
        $R1 = min($price_cheap, $not_heavy,$minimum_frets);
        $R2 = min($price_cheap, $not_heavy,$maximum_frets);
        $R3 = min($price_cheap, $heavy,$minimum_frets);
        $R4 = min($price_cheap, $heavy,$maximum_frets);
        
        
        $R5 = min($price_expensive, $not_heavy,$minimum_frets);
        $R6 = min($price_expensive, $not_heavy,$maximum_frets);
        $R7 = min($price_expensive, $heavy,$minimum_frets);
        $R8 = min($price_expensive, $heavy,$maximum_frets);
        //---------------------------------------------------------------------------------//


        //FIND MAX
        $Max1 = max($R1,$R2,$R3,$R4);
        $Max2 = max($R5,$R6,$R7,$R8);
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
    include("output.php");
}
?>