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
        $this->tree = $this->createdNestedTable();

        return $this->tree;
    }

    public function createdNestedTable() {

        $nestedTable = [];
        sort($this->flatData);

        foreach ($this->flatData as $title) {
            preg_match_all('~\d{1,3}.~', $title, $chapterNumbers);
            $chapterNumbers = array_reverse($chapterNumbers[0]);
            $arrayToAdd = [];
            $arrayToAdd[str_replace('.','',$chapterNumbers[0])] = [
                'index' => str_replace('.','',$chapterNumbers[0]),
                'level' => count($chapterNumbers),
                'title' => $title,
            ];

            for ($i = 1; $i < count($chapterNumbers); $i++) {
                $arrayChildren = $arrayToAdd;
                $arrayToAdd =[];
                $arrayToAdd[str_replace('.','',$chapterNumbers[$i])] = [
                    'index' => str_replace('.','',$chapterNumbers[$i]),
                    'level' => count($chapterNumbers),
                    'title' => '',
                    'children' => $arrayChildren
                ];
            }

            $nestedTable = array_replace_recursive($arrayToAdd, $nestedTable);
            asort($nestedTable);
        }
        return $nestedTable;
    }

    public function getTree()
    {
        return $this->tree;
    }

}
