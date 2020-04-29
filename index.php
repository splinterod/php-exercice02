<?php
// enable errors reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
//ajout initialisation xdebug pour affichage complet des var_dump
ini_set('xdebug.var_display_max_depth', '10');
ini_set('xdebug.var_display_max_children', '256');
ini_set('xdebug.var_display_max_data', '1024');
error_reporting(E_ALL);

require "vendor/autoload.php";

use App\TreeBuilder;

$input = [

   '1. Dénomination du médicament',
   '2. Effets indésirables',
    '2.1. Effet sur la grossesse',
    '3. Forme pharmaceutique',
    '3.1. Contre indications',
    '4. Données pharmaceutiques',
    '4.1. Données de sécurité préclinique',

];

$tree = new TreeBuilder($input);
$tree->build();
var_dump($tree->getTree());
