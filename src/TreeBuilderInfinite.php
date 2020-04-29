<?php

namespace App;

use Exception;

class TreeBuilderInfinite
{
    private $flatData = [];
    private $tree = [];

    public function __construct($flatData = [])
    {
        $this->flatData = $flatData;
    }

    public function build()
    {
        /*      tri du tableau initial afin de respecter l'ordre des chapitres.
               le tableau en sortie sera ainsi trié dans l'ordre des chapitres et
               on cela évitera de compléter ce tableau de facon aléatoire */
        sort($this->flatData);

        $nestedTable = [];

        //            Tests pour une nombre infini hierarchique
        $this->test();
        die();

        $this->tree = $nestedTable;

        return $this->tree;
    }

    public function test(){

    }

    public function getTree()
    {
        return $this->tree;
    }

}
