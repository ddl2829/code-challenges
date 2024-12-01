<?php


namespace AdventOfCode2015;

use PHPUnit\Framework\TestCase;

class Day1 extends TestCase
{
    public function solve($input, $partTwo = false) {
        $floor = 0;
        for($i = 0; $i < strlen($input); $i++) {
            if($input[$i] === "(") {
                $floor++;
            } else {
                $floor--;
            }
            if($partTwo && $floor === -1) {
                return $i + 1;
            }
        }
        return $floor;
    }

    public function test_first_part_example() {
        $input = <<<HERE
))(((((
HERE;
        $this->assertEquals(3, $this->solve($input));
    }

    public function test_first_part() {
        $input = file_get_contents(__DIR__ . '/data/day1');
        $this->assertEquals(232, $this->solve($input, true));
    }

    public function test_second_part_example() {
        $input = <<<HERE
()())
HERE;
        $this->assertEquals(5, $this->solve($input, true));
    }

    public function test_second_part() {
        $input = file_get_contents(__DIR__ . '/data/day1');
        $this->assertEquals(1783, $this->solve($input, true));
    }
}