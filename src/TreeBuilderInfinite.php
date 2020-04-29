<?php

namespace App;

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
        sort($this->flatData);

        // Tests pour une nombre infini hierarchique
        $this->test();
        die();

        $this->tree = $nestedTable;

        return $this->tree;
    }

    public function test()
    {

        $nestedTable = [];

        foreach ($this->flatData as $title) {
            preg_match_all('~\d{1,3}.~', $title, $chapterNumbers);
            // on va créer le tableau à ajouter en sens inverse
            $chapterNumbers = array_reverse($chapterNumbers[0]);

            // on reset le tableau qu'on va ajouter
            $arraytoAdd = [];

            // On ajoute le titre le dernier numéro de chapitre ainsi que le titre (donc 0 car $chapter est inversé)
            $arraytoAdd[filter_var($chapterNumbers[0], FILTER_SANITIZE_NUMBER_INT)] = [
                'index' => filter_var($chapterNumbers[0], FILTER_SANITIZE_NUMBER_INT),
                'title' => $title,
            ];

            // on reset le tableau qu'on va ajouter au tableau final
            $arrayForTable = [];

             /* On crée la profondeur (en fct de la longueur du tableau $chapter sauf pour chapterNumber[0]
            deja traité au dessus et si count($chapterNumber = 1 , on fait rien)*/
            for ($i = 1; $i < count($chapterNumbers); $i++) {
               /* premiere boucle on ajoute le tableau $arrayToAdd sinon on ajoute le arrayFor Table sur lui meme . En conservant les index et clés pour faciliter
                le merge entre les tableaux*/
                if ($i == 1) {
                    $arrayForTable[filter_var($chapterNumbers[$i], FILTER_SANITIZE_NUMBER_INT)] = [
                        'index' => filter_var($chapterNumbers[$i], FILTER_SANITIZE_NUMBER_INT),
                        'title' => '',
                        'children' => $arraytoAdd
                    ];
                } else {
                    $arrayForTable[filter_var($chapterNumbers[$i], FILTER_SANITIZE_NUMBER_INT)] = [
                        'index' => filter_var($chapterNumbers[$i], FILTER_SANITIZE_NUMBER_INT),
                        'title' => '',
                        'children' => $arrayForTable
                    ];
                }
            }

//            si arrayForTable = empty alors on est pas rentré dasn la boucle donc arrayForTable est vide
            $arrayForTable = (empty($arrayForTable)) ? $arraytoAdd : $arrayForTable;

              /*Le sens des arguments dans la fonction array_replace_recursive est important ici. On prend le tableau avec les nouvelles valeurs et on le complète
            avec  toutes les infos de nestedTable et pas l'inverse->perte de données*/
            $nestedTable = array_replace_recursive($arrayForTable, $nestedTable);
            asort($nestedTable);

        }
        //affichage du résultat
        var_dump($nestedTable);

    }

    public function getTree()
    {
        return $this->tree;
    }

}
