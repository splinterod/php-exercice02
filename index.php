<?php
// enable errors reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require "vendor/autoload.php";

use App\TreeBuilder;

$input = [
    '1. Dénomiation du médicament',
    '2. Effets indésirables',
    '2.1. Effet sur la grossesse',
    '3. Forme pharmaceutique',
    '3.1. Contre indications',
    '4. Données pharmaceutiques',
    '4.1. Données de sécurité préclinique'
];

$tree = new TreeBuilder($example);
$tree->build();
print_r($tree->getTree());
