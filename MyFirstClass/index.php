<?php
// Inclusief de Stoel klasse
include 'stoel.php';

// Maak een nieuwe stoel aan
$stoel = new Stoel("rood", 60);

// Output de eigenschappen van de stoel
echo "De stoel is: " . $stoel->getKleur() . "<br>";
echo "Zithoogte rode stoel: " . $stoel->getZithoogte() . "<br>";

// Verstel de zithoogte
$stoel->verstelZithoogte(70);

// Output de nieuwe zithoogte
echo "Zithoogte na verstelling: " . $stoel->getZithoogte() . "<br>";
?>
