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
            '1.2.1. test pour niveau un deux trois',
            '1.2.1.1. test pour niveau un deux trois',
            '1.2.1.2. test pour niveau un deux trois',
            '2. Effets indésirables',
            '2.1. Effet sur la grossesse',
            '2.1.1. Effet sur la enfants',
            '3. Forme pharmaceutique',
            '3.1. Contre indications',
            '3.2. contre les maladies',
            '4. Données pharmaceutiques',
            '4.1.2.3.6.3.5.6.9. Données de sécurité préclinique',
        ];

        sort($input);

        $tree = new TreeBuilderInfinite($input);
        $tree->build();
        $nestedTree = $tree->getTree();

        $origineTable = $this->findPosition($nestedTree);
        sort($origineTable);

        var_dump($origineTable);

        // validation des nums de chapitre
        for ( $i=0 ; $i<count($origineTable) ;$i=$i+2){
            $chapterNumber = explode(' ', $origineTable[$i+1], 2);
            $chapterNameTable[] = $origineTable[$i+1];
            if ($origineTable[$i] == $chapterNumber[0]){
                $testChapter = true;
            } else {
                $testChapter =false;
            }
        }

        sort($chapterNameTable);

        $this->assertEquals($input, $chapterNameTable);
        $this->assertEquals(true, $testChapter);

    }

    public function findPosition($treeBis, $originalTable = [], $index = "")
    {
        foreach ($treeBis as $key => $value) {

            $index = substr($index, 0, $treeBis[$key]['level'] * 2 - 2);

            $index = $index . $treeBis[$key]['index'] . ".";
            if($treeBis[$key]['title'] != ""){

                array_push($originalTable, $index);
                array_push($originalTable, $treeBis[$key]['title']);
            }

            if (isset($treeBis[$key]['children'])) {
                $originalTable = $this->findPosition($treeBis[$key]['children'], $originalTable, $index);
            }
        }
        return $originalTable;
    }

}

