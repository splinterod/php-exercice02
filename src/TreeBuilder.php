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
        // fill in this method
        // you can create other methods to organize your code.

        // @todo

        return $this;
    }

    public function getTree()
    {
        return $this->tree;
    }
}
