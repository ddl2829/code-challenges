<?php


namespace AdventOfCode2015;

use PHPUnit\Framework\TestCase;

class Day4 extends TestCase
{
    public function solve($input, $partTwo = false) {
        $num = 1;
        while(true) {
            $hash = md5($input . $num);
            $zeros = $partTwo ? "000000" : "00000";
            if(str_starts_with($hash, $zeros)) {
                return $num;
            }
            $num++;
        }
        return 0;
    }

    public function test_first_part_example() {
        $input = "abcdef";
        $this->assertEquals(609043, $this->solve($input));
    }

    public function test_first_part() {
        $input = "bgvyzdsv";
        $this->assertEquals(254575, $this->solve($input));
    }

    public function test_second_part() {
        $input = "bgvyzdsv";
        $this->assertEquals(1038736, $this->solve($input, true));
    }
}