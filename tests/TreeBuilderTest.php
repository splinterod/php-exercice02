<?php

use PHPUnit\Framework\TestCase;
use App\TreeBuilder;

final class TreeBuilderTest extends TestCase
{
    public function testTree(): void
    {
        $input = [
            '1. Dénomiation du médicament',
            '2. Effets indésirables',
            '2.1. Effet sur la grossesse',
            '3. Forme pharmaceutique',
            '3.1. Contre indications',
            '4. Données pharmaceutiques',
            '4.1. Données de sécurité préclinique',
            '4.2. Données test niveau 4',
            '4.3. Données test',
            '4.4. Données test',
        ];

        //on trie ici input car il sera trié dans la méthode getTree() donc nécessaire pour valider si les deux tableaux sont identiques
        sort($input);

        $tree = new TreeBuilder($input);
        $tree->build();
        $nestedTree = $tree->getTree();

//        Pour effectuer un test aussi bien sur la numérotation que que les titres, l'idée est de récréer le tableau d'origine
//        en partant du tableau assocatif: et si il y a un ecart -> il y a une erreur.
//        ce test est valable pour pour un niveau de hierarchie max de 2

        //Création du tableau d'origine  à partir  du tableau associatif
        $origineTable = [];

//       On parcours le tableau associatif
        Foreach($nestedTree as  $chapter){
/*            niveau hiearchique 1: on récupére l'index (numéro de chapitre) et on concatene avec le titre du chapitre
            en respectant le format "<number><dot> NOM CHAPITRE"*/
            array_push($origineTable, $chapter['index'] . ". " . $chapter['title']);
//           on vérifie si un niveau hierarchique niveau 2 existe dans le tableau associatif
            if(isset($chapter['children'])){
//                si oui , on parcours l'ensemble des sous chapitre de niveau 2
                Foreach($chapter['children'] as $subChpater){
/*                    ajoute au tableau normal chaques numéro de chapitre (en reprenant aussi le numero index niveau 1) et
                    on concatene avec le titre du sous chapitre  en respectant le format "<number><dot><number><dot> NOM CHAPITRE"*/
                    array_push($origineTable, $chapter['index'] . "." . $subChpater['index'] . ". ". $subChpater['title']);
                }
            }
        }

//        vérification si le tableau initial (trié) est identique au tableau créé à partir du tableau associatif
        $this->assertEquals($input,$origineTable);

        $this->assertCount(4, $nestedTree);
        // @todo: other simple tests to verify sub items...
    }
}
