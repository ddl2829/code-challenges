<?php


namespace AdventOfCode2015;

use PHPUnit\Framework\TestCase;

class Day6 extends TestCase
{
    public function solve($input) {
        $grid = array_fill(0, 1000, array_fill(0, 1000, false));
        $lines = explode("\n", $input);
        foreach($lines as $line) {
            preg_match_all("/(\d+),(\d+) through (\d+),(\d+)/", $line, $matches);
            $x1 = intval($matches[1][0]);
            $y1 = intval($matches[2][0]);
            $x2 = intval($matches[3][0]);
            $y2 = intval($matches[4][0]);

            for($x = $x1; $x <= $x2; $x++) {
                for($y = $y1; $y <= $y2; $y++) {
                    if (str_starts_with($line, "turn on")) {
                        $grid[$y][$x] = true;
                    } else {
                        if (str_starts_with($line, "toggle")) {
                            $grid[$y][$x] = !$grid[$y][$x];
                        } else {
                            if (str_starts_with($line, "turn off")) {
                                $grid[$y][$x] = false;
                            }
                        }
                    }
                }
            }
        }

        $lit = 0;
        foreach($grid as $row) {
            foreach($row as $col) {
                echo $col ? "*" : ".";
                if($col) {
                    $lit++;
                }
            }
            echo "\n";
        }

        return $lit;
    }

    public function solve2($input) {
        $grid = array_fill(0, 1000, array_fill(0, 1000, 0));
        $lines = explode("\n", $input);
        foreach($lines as $line) {
            preg_match_all("/(\d+),(\d+) through (\d+),(\d+)/", $line, $matches);
            $x1 = intval($matches[1][0]);
            $y1 = intval($matches[2][0]);
            $x2 = intval($matches[3][0]);
            $y2 = intval($matches[4][0]);

            for($x = $x1; $x <= $x2; $x++) {
                for($y = $y1; $y <= $y2; $y++) {
                    if (str_starts_with($line, "turn on")) {
                        $grid[$y][$x] += 1;
                    } else {
                        if (str_starts_with($line, "toggle")) {
                            $grid[$y][$x] += 2;
                        } else {
                            if (str_starts_with($line, "turn off")) {
                                $grid[$y][$x] -= 1;
                                if($grid[$y][$x] < 0) {
                                    $grid[$y][$x] = 0;
                                }
                            }
                        }
                    }
                }
            }
        }

        $brightness = 0;
        foreach($grid as $row) {
            foreach($row as $col) {
                echo $col;
                if($col) {
                    $brightness += $col;
                }
            }
            echo "\n";
        }

        return $brightness;
    }

    public function test_first_part() {
        $input = file_get_contents(__DIR__ . '/data/day6');
        $this->assertEquals(569999, $this->solve($input));
    }

    public function test_second_part() {
        $input = file_get_contents(__DIR__ . '/data/day6');
        $this->assertEquals(17836115, $this->solve2($input));
    }
}