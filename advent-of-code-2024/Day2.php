<?php


namespace AdventOfCode2024;

use PHPUnit\Framework\TestCase;

class Day2 extends TestCase
{
    private function isSafe($numbers) {
        $increasing = $numbers[0] < $numbers[1];
        foreach($numbers as $index => $number) {
            if($index > 0) {
                if($increasing) {
                    if($number <= $numbers[$index - 1]) {
                        return false;
                    }
                } else {
                    if($number >= $numbers[$index - 1]) {
                        return false;
                    }
                }
                $difference = abs($number - $numbers[$index - 1]);
                if($difference > 3) {
                    return false;
                }
            }
        }
        return true;
    }

    public function solve($input, $partTwo = false)
    {
        $lines = explode("\n", $input);
        $safeReports = 0;
        foreach($lines as $line) {
            $numbers = array_map(function($v) {
                return intval($v);
            }, explode(" ", $line));
            if($this->isSafe($numbers)) {
                $safeReports++;
            } else if($partTwo) {
                for($i = 0; $i < count($numbers); $i++) {
                    $newNumbers = [...$numbers];
                    unset($newNumbers[$i]);
                    if($this->isSafe(array_values($newNumbers))) {
                        $safeReports++;
                        continue 2;
                    }
                }
            }
        }
        return $safeReports;
    }

    public function test_first_part_example()
    {
        $input = <<<HERE
7 6 4 2 1
1 2 7 8 9
9 7 6 2 1
1 3 2 4 5
8 6 4 4 1
1 3 6 7 9
HERE;
        $this->assertEquals(2, $this->solve($input));
    }

    public function test_first_part()
    {
        $input = file_get_contents(__DIR__ . '/data/day2');
        $this->assertEquals(564, $this->solve($input));
    }

    public function test_second_part_example()
    {
        $input = <<<HERE
7 6 4 2 1
1 2 7 8 9
9 7 6 2 1
1 3 2 4 5
8 6 4 4 1
1 3 6 7 9
HERE;
        $this->assertEquals(4, $this->solve($input, true));
    }

    public function test_second_part()
    {
        $input = file_get_contents(__DIR__ . '/data/day2');
        $this->assertEquals(604, $this->solve($input, true));
    }
}