<?php

namespace AdventOfCode2021;

use PHPUnit\Framework\TestCase;

class Day1 extends TestCase
{
    public function solve($input, $partTwo = false) {
        $lines = explode("\n", $input);

        if($partTwo) {
            $windows = [];
            foreach($lines as $index => $line) {
                if($index < count($lines) - 2) {
                    $window = [$line];
                    $window[] = $lines[$index + 1];
                    $window[] = $lines[$index + 2];
                    $windows[] = $window;
                }
            }
            $lines = array_map('array_sum', $windows);
        }

        $increases = 0;
        $previous = null;
        foreach($lines as $line) {
            echo $line . " ";
            if($previous !== null) {
                if($line > $previous) {
                    $increases++;
                    echo "increased";
                } else {
                    echo "decreased";
                }
            }
            echo "\n";
            $previous = $line;
        }
        return $increases;
    }

    public function test_first_part_example() {
        $input = <<<HERE
199
200
208
210
200
207
240
269
260
263
HERE;
        $this->assertEquals(7, $this->solve($input));
    }

    public function test_first_part() {
        $input = file_get_contents('data/day1');
        $this->assertEquals(1692, $this->solve($input, true));
    }

    public function test_second_part_example() {
        $input = <<<HERE
199
200
208
210
200
207
240
269
260
263
HERE;
        $this->assertEquals(5, $this->solve($input, true));
    }

    public function test_second_part() {
        $input = file_get_contents('data/day1');
        $this->assertEquals(1724, $this->solve($input, true));
    }
}