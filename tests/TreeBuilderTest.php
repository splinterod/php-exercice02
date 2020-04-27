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
            '4.1. Données de sécurité préclinique'
        ];

        $tree = new TreeBuilder($input);
        $tree->build();
        $nestedTree = $tree->getTree();

        // complete the unit test here...
        // make sure the top items number is correct
        // make sure nested item values are correct

        $this->assertCount(4, $nestedTree);
        // @FILLTHIS
        // other simple tests to verify sub items... ?
    }
}
