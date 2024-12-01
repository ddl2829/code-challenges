<?php

namespace AdventOfCode2021;

use PHPUnit\Framework\TestCase;

class Day2 extends TestCase
{
    public function solve($input, $partTwo = false) {
        $horiz = 0;
        $depth = 0;
        $aim = 0;

        $lines = explode("\n", $input);
        foreach($lines as $line) {
            [$command, $amount] = explode(" ", $line);
            if($partTwo) {
                switch ($command) {
                    case 'forward':
                        $horiz += $amount;
                        $depth += $aim * $amount;
                        break;
                    case 'down':
                        $aim += $amount;
                        break;
                    case 'up':
                        $aim -= $amount;
                        break;
                }
            } else {
                switch ($command) {
                    case 'forward':
                        $horiz += $amount;
                        break;
                    case 'down':
                        $depth += $amount;
                        break;
                    case 'up':
                        $depth -= $amount;
                        break;
                }
            }
        }

        return $depth * $horiz;
    }

    public function test_first_part_example() {
        $input = <<<HERE
forward 5
down 5
forward 8
up 3
down 8
forward 2
HERE;
        $this->assertEquals(150, $this->solve($input));
    }

    public function test_first_part() {
        $input = file_get_contents(__DIR__ . '/data/day2');
        $this->assertEquals(1714950, $this->solve($input, true));
    }

    public function test_second_part_example() {
        $input = <<<HERE
forward 5
down 5
forward 8
up 3
down 8
forward 2
HERE;
        $this->assertEquals(900, $this->solve($input, true));
    }

    public function test_second_part() {
        $input = file_get_contents(__DIR__ . '/data/day2');
        $this->assertEquals(1281977850, $this->solve($input, true));
    }
}