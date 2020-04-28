<?php

use PHPUnit\Framework\TestCase;
use App\TreeBuilder;

final class TreeBuilderTest extends TestCase
{
    public function testTree(): void
    {
        $input = [
            '4.1. Données de sécurité préclinique',
            '1. Dénomiation du médicament',
            '2. Effets indésirables',
            '2.1. Effet sur la grossesse',
            '3. Forme pharmaceutique',
            '3.1. Contre indications',
            '4. Données pharmaceutiques'
        ];

        //action en doublon avec le code de la méthode getTree()
        sort($input);

        $tree = new TreeBuilder($input);
        $tree->build();
        $nestedTree = $tree->getTree();

        // complete the unit test here...
        // make sure the top items number is correct
        // make sure nested item values are correct

        //Création du tableau initial à partir  du tableau associatif
        $originalTable = [];

//       On parcours le tableau associatif
        Foreach($nestedTree as  $chapter){
//            niveau hiearchique 1: on récupére l'index (numéro de chapitre) et on concatene avec le titre du chapitre
            array_push($originalTable, $chapter['index'] . ". " . $chapter['title']);
//           on vérifie si un niveau hierarchique 2 existe
            if(isset($chapter['children'])){
//                on parcours l'ensemble des sous chapitre de niveau 2
                Foreach($chapter['children'] as $subChpater){
//                    ajoute au tableau normal chaques numéro de chapitre (en reprenant aussi le numero index niveau 1) et
//                    on concatene avec le titre du sous chapitre
                    array_push($originalTable, $chapter['index'] . "." . $subChpater['index'] . ". ". $subChpater['title']);
                }

            }
        }

        $this->assertEquals($input,$originalTable);

        $this->assertCount(4, $nestedTree);
        // @todo: other simple tests to verify sub items...
    }
}
