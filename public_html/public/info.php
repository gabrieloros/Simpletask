<?php

//echo phpinfo(); 

$cadena = "-32.90660063906105|-68.85388812422758,-32.92317283709698|-68.86247119307524,-32.9125093438245|-68.88015231490141,-32.9125093438245|-68.83912524580961,-32.890169485130166|-68.86779269576078,-32.88699820982297|-68.85611972212797,-32.894926185263444|-68.85285815596586";
$array = explode(",", $cadena);
echo "<br><br>El número de elementos en el array es: " . count($array);
foreach  ($array as $valor) { 

    $latLong = explode("|", $valor);
    echo $latLong[0];
    echo $latLong[1];
    echo "<br>";
}
//echo $array;

// (-32.90962709808188, -68.86435946822172),(-32.90971367447134, -68.86369671210514),(-32.90973168878103, -68.86349286422),(-32.90974069593449, -68.86326755866276),(-32.90973168878103, -68.86318172797428),(-32.909695660157986, -68.86303152426945),(-32.90968665299994, -68.86265601500736),(-32.909695660157986, -68.86237706526981),(-32.90968665299994, -68.8621410308765),(-32.90967764584097, -68.86199082717167)
?>
