<?php


namespace AdventOfCode2024;

use PHPUnit\Framework\TestCase;

class Day3 extends TestCase
{
    public function solve($input, $partTwo = false)
    {
        if($partTwo) {
            preg_match_all("/(mul\(\d{1,3},\d{1,3}\)|do\(\)|don't\(\))/", $input, $matches);
        } else {
            preg_match_all("/mul\(\d{1,3},\d{1,3}\)/", $input, $matches);
        }
        $out = 0;
        $do = true;
        foreach($matches[0] as $match) {
            if($match === "do()") {
                $do = true;
            }
            if($match === "don't()") {
                $do = false;
                continue;
            }
            if($do) {
                $numbers = explode(",", str_replace("mul(", "", str_replace(")", "", $match)));
                $out += intval($numbers[0]) * intval($numbers[1]);
            }
        }
        return $out;
    }

    public function test_first_part_example()
    {
        $input = <<<HERE
xmul(2,4)%&mul[3,7]!@^do_not_mul(5,5)+mul(32,64]then(mul(11,8)mul(8,5))
HERE;
        $this->assertEquals(161, $this->solve($input));
    }

    public function test_first_part()
    {
        $input = file_get_contents(__DIR__ . '/data/day3');
        $this->assertEquals(175615763, $this->solve($input));
    }

    public function test_second_part_example()
    {
        $input = <<<HERE
xmul(2,4)&mul[3,7]!^don't()_mul(5,5)+mul(32,64](mul(11,8)undo()?mul(8,5))
HERE;
        $this->assertEquals(48, $this->solve($input, true));
    }

    public function test_second_part()
    {
        $input = file_get_contents(__DIR__ . '/data/day3');
        $this->assertEquals(74361272, $this->solve($input, true));
    }
}