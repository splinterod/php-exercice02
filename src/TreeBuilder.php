<?php

namespace App;

class TreeBuilder
{
    private $flatData = [];
    private $itemsArranged = [];
    private $tree = [];

    public function __construct($flatData = [])
    {
        $this->flatData = $flatData;
    }

    public function build()
    {
        // fill in this method
        // you can create other methods to organize your code.
        $nLevels = 0;
        $leveledData = [];
        $data = [];

        // @FILLTHIS
        foreach ($this->flatData as $row) {
            $info = self::info($row);

            $this->itemsArranged[] = [
                'row' => $row,
                'numid' => $info['numid'],
                'level' => $info['level'],
                'parent' => $info['parent'],
            ];
        }

        $this->tree = $this->mapTree($this->itemsArranged, null, 1);

        return $this;
    }

    private function mapTree(array $items, $parent = null, $level = 1)
    {
        $tree = [];

        foreach ($items as $k => $item) {

            if ($level !== $item['level']) {
                continue;
            }

            $tree[$k] = $item;
            $tree[$k]['children'] = [];

            $children = self::findChildrenIn($this->itemsArranged, $item['numid']);
            $tree[$k]['children'] = $this->mapTree($children, $item, ($level + 1));
        }

        // could sort tree as well...
        return array_values($tree);
    }

    public static function findChildrenIn($list, $numid)
    {
        $children = [];

        foreach ($list as $item) {
            if ($item['parent'] === $numid) {
                $children[] = $item;
            }
        }

        return $children;
    }

    public static function info($row)
    {
        $parts = explode('.', $row); // 2 , 1
        $level = count($parts) - 1;
        $nums = array_splice($parts, 0, count($parts) - 1);
        $label = $parts[count($parts) - 1];

        $parent = null;
        $numid = implode('.', $nums);

        if (count($nums) > 1) {
            $pnums = array_splice($nums, 0, count($nums) - 1);
            $parent = implode('.', $pnums);
        }

        return [ 'level' => $level, 'numid' => $numid, 'label' => $label, 'parent' => $parent];
    }

    public function getTree()
    {
        return $this->tree;
    }
}
