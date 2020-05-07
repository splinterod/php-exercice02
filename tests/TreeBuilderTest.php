<?php

use App\TreeBuilderInfinite;
use PHPUnit\Framework\TestCase;

final class TreeBuilderTest extends TestCase
{
    public function testTree(): void
    {
        $input = [
            '1. Dénomination du médicament',
            '1.1. tests niveau un un',
            '1.2. tests niveau un deux',
            '1.2.3 test pour niveau un deux trois',
            '1.2.3.4.5.6.7.8.9. test un deux trois quatre cinq six',
            '2. Effets indésirables',
            '2.1. Effet sur la grossesse',
            '2.1.1. Effet sur la enfants',
            '3. Forme pharmaceutique',
            '3.1. Contre indications',
            '4. Données pharmaceutiques',
            '4.1. Données de sécurité préclinique',
        ];

        //on trie ici input car il sera trié dans la méthode getTree() donc nécessaire pour valider si les deux tableaux sont identiques
        sort($input);

        $tree = new TreeBuilderInfinite($input);
        $tree->build();
        $nestedTree = $tree->getTree();

        $it = new RecursiveIteratorIterator(new RecursiveArrayIterator($nestedTree));
        foreach($it as $k => $v) {
            if($v!= ''){
                if($k==='title'){
                    $origineTable[]= $v;
                }
            }
        }
        sort($origineTable);
        $this->assertEquals($input,$origineTable);

        // @todo: other simple tests to verify sub items...
    }
}
