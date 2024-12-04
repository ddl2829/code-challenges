<?php


namespace AdventOfCode2024;

use PHPUnit\Framework\TestCase;

class Day4 extends TestCase
{
    public function solve($input, $partTwo = false)
    {
        $lines = explode("\n", $input);
        $grid = array_map(function($line) {
            return str_split($line);
        }, $lines);
        $count = 0;

        if($partTwo) {
            $directions = [
                [-1, -1],
                [1, 1],
                [1, -1],
                [-1, 1]
            ];
            foreach($grid as $yIndex => $row) {
                if($yIndex === 0 || $yIndex === count($grid) - 1) {
                    continue;
                }
                foreach($row as $xIndex => $char) {
                    if($xIndex === 0 || $xIndex === count($row) - 1) {
                        continue;
                    }
                    $masses = 0;
                    foreach($directions as $d) {
                        if ($this->saysWordFrom(['M', 'A', 'S'], $grid, $xIndex + $d[0], $yIndex + $d[1], $d[0] * -1, $d[1] * -1)) {
                            $masses++;
                        }
                        if($masses === 2) {
                            $count++;
                            continue 2;
                        }
                    }
                }
            }
            return $count;
        }

        $directions = [
            [0, 1], // top and bottom middle
            [0, -1],

            [1, 0], // left and right middle
            [-1, 0],

            [-1, -1],
            [1, 1],
            [1, -1],
            [-1, 1]
        ];

        foreach($grid as $yIndex => $row) {
            foreach($row as $xIndex => $char) {
                foreach($directions as $d) {
                    if ($this->saysWordFrom(['X', 'M', 'A', 'S'], $grid, $xIndex, $yIndex, $d[0], $d[1])) {
                        $count++;
                    }
                }
            }
        }

        return $count;
    }

    private function saysWordFrom($chars, $grid, $x, $y, $xDir, $yDir) {
        foreach($chars as $seek) {
            if($grid[$y][$x] !== $seek) {
                return false;
            }
            $x += $xDir;
            $y += $yDir;
        }

        return true;
    }

    public function test_first_part_example()
    {
        $input = <<<HERE
MMMSXXMASM
MSAMXMSMSA
AMXSXMAAMM
MSAMASMSMX
XMASAMXAMM
XXAMMXXAMA
SMSMSASXSS
SAXAMASAAA
MAMMMXMMMM
MXMXAXMASX
HERE;
        $this->assertEquals(18, $this->solve($input));
    }

    public function test_first_part()
    {
        $input = file_get_contents(__DIR__ . '/data/day4');
        $this->assertEquals(2378, $this->solve($input));
    }

    public function test_second_part_example()
    {
        $input = <<<HERE
MMMSXXMASM
MSAMXMSMSA
AMXSXMAAMM
MSAMASMSMX
XMASAMXAMM
XXAMMXXAMA
SMSMSASXSS
SAXAMASAAA
MAMMMXMMMM
MXMXAXMASX
HERE;
        $this->assertEquals(9, $this->solve($input, true));
    }

    public function test_second_part()
    {
        $input = file_get_contents(__DIR__ . '/data/day4');
        $this->assertEquals(1796, $this->solve($input, true));
    }
}