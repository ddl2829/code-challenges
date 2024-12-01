<?php

namespace AdventOfCode2021;

use PHPUnit\Framework\TestCase;

class Day3 extends TestCase
{
    public function solve($input, $partTwo = false) {
        $gamma = "";

        $lines = explode("\n", $input);

        if($partTwo) {
            $next = $lines;

            $currentPosition = 0;
            while(count($next) > 1) {
                $zeros = [];
                $ones = [];
                foreach ($next as $line) {
                    if ($line[$currentPosition] === "0") {
                        $zeros[] = $line;
                    } else {
                        $ones[] = $line;
                    }
                }
                if (count($zeros) > count($ones)) {
                    $next = $ones;
                } else {
                    if (count($ones) > count($zeros)) {
                        $next = $zeros;
                    } else {
                        // tie
                        $next = $zeros;
                    }
                }
                $currentPosition++;
            }
            $oxygen = $next[0];

            $next = $lines;
            $currentPosition = 0;
            while(count($next) > 1) {
                $zeros = [];
                $ones = [];
                foreach ($next as $line) {
                    if ($line[$currentPosition] === "0") {
                        $zeros[] = $line;
                    } else {
                        $ones[] = $line;
                    }
                }
                if (count($zeros) > count($ones)) {
                    $next = $zeros;
                } else {
                    if (count($ones) > count($zeros)) {
                        $next = $ones;
                    } else {
                        // tie
                        $next = $ones;
                    }
                }
                $currentPosition++;
            }
            $co2 = $next[0];

            return bindec($oxygen) * bindec($co2);
        }


        $i = 0;
        while($i < strlen($lines[0])) {
            $val = 0;
            foreach ($lines as $line) {
                if($line[$i] === "0") {
                    $val--;
                } else {
                    $val++;
                }
            }
            if($val > 0) {
                $gamma .= "1";
            } else {
                $gamma .= "0";
            }
            $i++;
        }
        $toXor = str_repeat("1", strlen($gamma));
        $gamma = bindec($gamma);
        $epsilon = $gamma ^ bindec($toXor);
        return $gamma * $epsilon;
    }

    public function test_first_part_example() {
        $input = <<<HERE
00100
11110
10110
10111
10101
01111
00111
11100
10000
11001
00010
01010
HERE;
        $this->assertEquals(198, $this->solve($input));
    }

    public function test_first_part() {
        $input = file_get_contents(__DIR__ . '/data/day3');
        $this->assertEquals(1458194, $this->solve($input, true));
    }

    public function test_second_part_example() {
        $input = <<<HERE
00100
11110
10110
10111
10101
01111
00111
11100
10000
11001
00010
01010
HERE;
        $this->assertEquals(230, $this->solve($input, true));
    }

    public function test_second_part() {
        $input = file_get_contents(__DIR__ . '/data/day3');
        $this->assertEquals(2829354, $this->solve($input, true));
    }
}