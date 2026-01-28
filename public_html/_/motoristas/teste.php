<?php

include("../classes/maps.php");
$mps = new maps();
$latitude = "-28.06309";
$longitude = "-51.9968";
$lat_ini = "-28.0629529";
$lng_ini = "-52.017185";

$distancia = $mps->get_distance($latitude, $longitude, $lat_ini, $lng_ini);
echo "Distancia: " . $distancia['km'] . " km<br>";
echo "Tempo: " . $distancia['minutos'] . " minutos<br>";
?>