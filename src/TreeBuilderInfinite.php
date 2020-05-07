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
        $this->tree = $this->createdNestedTable();

        return $this->tree;
    }

    public function createdNestedTable() {

        $nestedTable = [];

        foreach ($this->flatData as $title) {
            preg_match_all('~\d{1,3}.~', $title, $chapterNumbers);
            $chapterNumbers = array_reverse($chapterNumbers[0]);
            $arrayToAdd = [];

            $arrayToAdd[filter_var($chapterNumbers[0], FILTER_SANITIZE_NUMBER_INT)] = [
                'index' => filter_var($chapterNumbers[0], FILTER_SANITIZE_NUMBER_INT),
                'title' => $title,
            ];

            for ($i = 1; $i < count($chapterNumbers); $i++) {
                $arrayChildren = $arrayToAdd;
                $arrayToAdd =[];
                $arrayToAdd[filter_var($chapterNumbers[$i], FILTER_SANITIZE_NUMBER_INT)] = [
                        'index' => filter_var($chapterNumbers[$i], FILTER_SANITIZE_NUMBER_INT),
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
