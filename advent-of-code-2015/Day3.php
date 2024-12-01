<?php


namespace AdventOfCode2015;

use PHPUnit\Framework\TestCase;

class Day3 extends TestCase
{
    public function applyMap(&$grid, $map, $size) {
        $x = $size / 2;
        $y = $size / 2;
        foreach($map as $dir) {
            switch($dir) {
                case '^':
                    $y -= 1;
                    break;
                case '>':
                    $x += 1;
                    break;
                case 'v':
                    $y += 1;
                    break;
                case '<':
                    $x -= 1;
                    break;
            }
            $grid[$y][$x] += 1;
        }
    }

    public function solve($input, $partTwo = false) {
        $gridSize = 200;
        $grid = array_fill(0, $gridSize, array_fill(0, $gridSize, 0));
        $x = $gridSize / 2;
        $y = $gridSize / 2;
        $grid[$y][$x] = 1;

        $map = str_split($input);
        if($partTwo) {
            // make two maps with alternating characters
            $map1 = [];
            $map2 = [];
            foreach($map as $i => $m) {
                if($i % 2 === 0) {
                    $map1[] = $m;
                } else {
                    $map2[] = $m;
                }
            }
            $this->applyMap($grid, $map1, $gridSize);
            $this->applyMap($grid, $map2, $gridSize);
        } else {
            $this->applyMap($grid, $map, $gridSize);
        }

        $total = 0;
        foreach($grid as $row) {
            foreach($row as $col) {
                echo $col;
                if($col > 0) {
                    $total++;
                }
            }
            echo "\n";
        }

        echo "\n\n";

        return $total;
    }

    public function test_first_part_example() {
        $input = ">";
        $this->assertEquals(2, $this->solve($input));

        $input = "^v^v^v^v^v";
        $this->assertEquals(2, $this->solve($input));

        $input = "^>v<";
        $this->assertEquals(4, $this->solve($input));
    }

    public function test_first_part() {
        $input = file_get_contents(__DIR__ . '/data/day3');
        $this->assertEquals(2081, $this->solve($input, true));
    }

    public function test_second_part_example() {
        $input = "^v^v^v^v^v";
        $this->assertEquals(11, $this->solve($input, true));
    }

    public function test_second_part() {
        $input = file_get_contents(__DIR__ . '/data/day3');
        $this->assertEquals(2341, $this->solve($input, true));
    }
}