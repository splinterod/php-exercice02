<?php

namespace App;

use Exception;

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
        /*      tri du tableau initial afin de respecter l'ordre des chapitres.
               le tableau en sortie sera ainsi trié dans l'ordre des chapitres et
               on cela évitera de compléter ce tableau de facon aléatoire */
        sort($this->flatData);

        $nestedTable = [];

        // on parcours toutes les lignes du tableau initial
        foreach ($this->flatData as $title) {
            /* extraction des numéros de chapitre avec une expression réguliere: $chapterNumbers est un array.
             on peux gérer jusqu'au chapitre 999.999. */
            preg_match_all('~\d{1,3}.~', $title, $chapterNumbers);

            /*   Permet de connaitre la "profondeur" du chapitre :
              si  la taille de $chapterNumbers = 1  alors chapitre niveau 1.
              Si la taille de $chapterNumbers = 2 alors chapitre de niveau 2 (enfants d'un chapitre de niveau 1)... */
            $indexSize = count($chapterNumbers[0]);

            /* en fonction de la "profondeur" du titre de chapitre en cours d'analyse, on le positionne dans le tableau de sortie en fct de son niveau hierarchique.
             On ajoute directement le titre et l'index au bon endroit dans le tableau ( les clés et la valeur "index" sont les memes ): On n'a pas à se soucier de l'ordre
             lequel les titres sont classés dans le tableau initial. D'autant plus que la source a été trié */
            switch ($indexSize) {
                case 1:
                    // extraction du numéro de chapitre ( sous forme d. ) issu du preg_match_all
                    $level1 = filter_var($chapterNumbers[0][0][0], FILTER_SANITIZE_NUMBER_INT);
                    /* on ajoute titre et index au tableau (à voir si la conservation de la valeur "index" est nécessaire)
                   Avant l'ajout , on pourrais tester si la valeur existe déja*/
                    $nestedTable[$level1]["index"] = $level1;
//                     on ajoute le titre en enlevant les 3 premiers caractères correspondant au numéro de chapitre (<number><dot><space>)
                    $nestedTable[$level1]["title"] = substr($title, 3);
                    break;
                case 2:
                    $level1 = filter_var($chapterNumbers[0][0][0], FILTER_SANITIZE_NUMBER_INT);
                    $level2 = filter_var($chapterNumbers[0][1][0], FILTER_SANITIZE_NUMBER_INT);
                    $nestedTable[$level1]["children"][$level2]["index"] = $level2;
                    //on ajoute le titre en enlever les 5 premiers caractères correspondant au numéro de chapitre (<number><dot><number><dot><space>)
                    $nestedTable[$level1]["children"][$level2]["title"] = substr($title, 5);
                    break;
                default:
//                    au cas ou le niveau hierarchique dépasse 2, on renvoie une erreur afin d'éviter de remonter un tableau incomplet
                    throw new Exception('le nombre de niveau hierarchique max (2 niveaux) est atteint');
            }
        }
        $this->tree = $nestedTable;

        return $this->tree;
    }

    public function getTree()
    {
        return $this->tree;
    }

}
