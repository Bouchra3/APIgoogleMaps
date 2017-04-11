<?php

$pdo = new PDO('mysql:host=localhost;dbname=lieux_de_tournage', 'root', '', array(
PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
));

//Information pour la latitude et longitude
$infos = $pdo ->query("SELECT geo_coordinates, Titre, Realisateur FROM lieux LIMIT 0,150");

$resultat = $infos->fetchAll(PDO::FETCH_ASSOC);
 //var_dump($recup);
