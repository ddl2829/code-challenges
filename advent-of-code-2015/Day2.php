<?php


namespace AdventOfCode2015;

use PHPUnit\Framework\TestCase;

class Day2 extends TestCase
{
    public function solve($input, $partTwo = false) {
        $lines = explode("\n", $input);
        $total = 0;
        if($partTwo) {
            foreach($lines as $line) {
                $dimensions = explode("x", $line);
                sort($dimensions);
                $total += 2 * $dimensions[0] + 2 * $dimensions[1];
                $total += $dimensions[0] * $dimensions[1] * $dimensions[2];
            }

            return $total;
        }

        foreach($lines as $line) {
            [$l, $w, $h] = explode("x", $line);
            $areas = [
                2 * $l * $w,
                2 * $l * $h,
                2 * $w * $h
            ];
            sort($areas);
            $extra = $areas[0] / 2;
            $total += array_sum($areas) + $extra;
        }
        return $total;
    }

    public function test_first_part_example() {
        $input = <<<HERE
2x3x4
HERE;
        $this->assertEquals(58, $this->solve($input));
    }

    public function test_first_part() {
        $input = file_get_contents(__DIR__ . '/data/day2');
        $this->assertEquals(1598415, $this->solve($input, true));
    }

    public function test_second_part_example() {
        $input = <<<HERE
2x3x4
HERE;
        $this->assertEquals(34, $this->solve($input, true));
    }

    public function test_second_part() {
        $input = file_get_contents(__DIR__ . '/data/day2');
        $this->assertEquals(3812909, $this->solve($input, true));
    }
}