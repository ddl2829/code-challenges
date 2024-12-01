<?php


namespace AdventOfCode2024;

use PHPUnit\Framework\TestCase;

class Day1 extends TestCase
{
    public function solve($input, $partTwo = false)
    {
        // get 2 sorted lists from the columns
        $left = [];
        $right = [];

        $lines = explode("\n", $input);
        foreach($lines as $line) {
            $parts = explode("   ", $line);
            $left[] = $parts[0];
            $right[] = $parts[1];
        }

        sort($left);
        sort($right);

        if(count($left) !== count($right)) {
            throw new \Exception("Left and right columns must have the same number of elements");
        }

        if($partTwo) {
            $right = array_count_values($right);
        }

        $totalDistance = 0;
        for($i = 0; $i < count($left); $i++) {
            if($partTwo) {
                $totalDistance += intval($left[$i]) * ($right[$left[$i]] ?? 0);
            } else {
                $totalDistance += abs(intval($left[$i]) - intval($right[$i]));
            }
        }

        return $totalDistance;
    }

    public function test_first_part_example()
    {
        $input = <<<HERE
3   4
4   3
2   5
1   3
3   9
3   3
HERE;
        $this->assertEquals(11, $this->solve($input));
    }

    public function test_first_part()
    {
        $input = file_get_contents(__DIR__ . '/data/day1');
        $this->assertEquals(2166959, $this->solve($input));
    }

    public function test_second_part_example()
    {
        $input = <<<HERE
3   4
4   3
2   5
1   3
3   9
3   3
HERE;
        $this->assertEquals(31, $this->solve($input, true));
    }

    public function test_second_part()
    {
        $input = file_get_contents(__DIR__ . '/data/day1');
        $this->assertEquals(23741109, $this->solve($input, true));
    }
}