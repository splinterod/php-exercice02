<?php

namespace App;

class TreeBuilder
{
    private $flatData = [];
    private $tree = [];

    public function __construct($flatData = [])
    {
        $this->flatData = $flatData;
    }

    public function build()
    {
        $output = [];

        // on parcours toutes les lignes du tableau initial
        foreach ($this->flatData as $title) {
            // extraction des numéros de chapitre avec une expression réguliere: $chapterNumbers est un array.
            //on peux gérer jusqu'au chapitre 999.999.
            preg_match_all('~\d{1,3}.~', $title, $chapterNumbers);

            // Permet de connaitre la "profondeur" du chapitre :
            // si  la taille de $chapterNumbers = 1  alors chapitre niveau 1.
            // Si la taille de $chapterNumbers = 2 alors chapitre de niveau 2 (enfants d'un chapitre de niveau 1)...
            $indexSize = count($chapterNumbers[0]);

            // en fonction de la "profondeur" du titre de chapitre en cours d'analyse, on le positionne dans le tableau de sortie en fct de son niveau hierarchique.
            // On ajoute directement le titre et l'index au bon endroit dans le tableau ( les clés et la valeur "index" sont les memes ): On n'a pas à se soucier de l'ordre
            // lequel les titres sont classés dans le tableau initial.
            switch ($indexSize) {
                case 1:
                    // extraction du numéro de chapitre ( sous forme d. ) issu du preg_match_all
                    $level1 = filter_var($chapterNumbers[0][0][0], FILTER_SANITIZE_NUMBER_INT);
                    //  on ajoute titre et index au tableau (à voir si la conservation de la valeur "index" est nécessaire)
//                Avant l'ajout , on pourrais tester si la valeur existe daje

                    $output[$level1]["index"] = $level1;
//                     on ajoute le titre en enlevant les 3 premiers caractères correspondant au numéro de chapitre (<number><dot><space>)
                    $output[$level1]["title"] = substr($title,3);
//
                    break;
                case 2:
                    $level1 = filter_var($chapterNumbers[0][0][0], FILTER_SANITIZE_NUMBER_INT);
                    $level2 = filter_var($chapterNumbers[0][1][0], FILTER_SANITIZE_NUMBER_INT);
                    $output[$level1]["children"][$level2]["index"] = $level2;
                    //on ajoute le titre en enlever les 5 premiers caractères correspondant au numéro de chapitre (<number><dot><number><dot><space>)
                    $output[$level1]["children"][$level2]["title"] = substr($title,5);
                    break;
                default:
                    throw new Exception('le nombre de niveau hierarchique max (2 niveaux) est atteint');
            }
        }
        $this->tree = $output;

        return $this->tree;
    }

    public function getTree()
    {
        return $this->tree;
    }
}
