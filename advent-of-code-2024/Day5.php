<?php


namespace AdventOfCode2024;

use PHPUnit\Framework\TestCase;

class Day5 extends TestCase
{
    public function solve($input, $partTwo = false)
    {

        $lines = explode("\n", $input);
        $rules = [];
        $updates = [];

        foreach($lines as $line) {
            if(empty($line)) {
                continue;
            }
            if(strpos($line, '|') !== false) {
                $rules[] = array_map(function($a) { return intval($a); }, explode("|", $line));
            } else {
                $updates[] = array_map(function($a) { return intval($a); }, explode(",", $line));
            }
        }

        $total = 0;
        $partTwoTotal = 0;
        foreach($updates as $update) {
            if($this->isLineValid($update, $rules)) {
                $middle = $update[floor(count($update) / 2)];
                $total += intval($middle);
            } else if($partTwo) {
                // use the ordering rules to fix the order
                $corrected = $this->fixOrder($update, $rules);
                $middle = $corrected[floor(count($corrected) / 2)];
                $partTwoTotal += intval($middle);
            }
        }

        return $partTwo ? $partTwoTotal : $total;
    }

    private function fixOrder($line, $rules) {
        $corrected = [$line[0]];
        for($i = 1; $i < count($line); $i++) {
            for($j = 0; $j <= count($corrected); $j++) {
                $cpy = [...$corrected];
                array_splice($cpy, $j, 0, $line[$i]);
                if($this->isLineValid($cpy, $rules)) {
                    $corrected = $cpy;
                    break;
                }
            }
        }

        return $corrected;
    }

    private function isLineValid($line, $rules) {
        for($i = 0; $i < count($line); $i++) {
            $validating = $line[$i];
            for($j = $i + 1; $j < count($line); $j++) {
                $checkAgainst = $line[$j];

                // check rules for either of these values, check the order of them
                foreach($rules as $rule) {
                    if($rule[0] === $checkAgainst && $rule[1] === $validating) {
                        return false;
                    }
                }
            }
        }
        return true;
    }

    public function test_first_part_example()
    {
        $input = <<<HERE
47|53
97|13
97|61
97|47
75|29
61|13
75|53
29|13
97|29
53|29
61|53
97|53
61|29
47|13
75|47
97|75
47|61
75|61
47|29
75|13
53|13

75,47,61,53,29
97,61,53,29,13
75,29,13
75,97,47,61,53
61,13,29
97,13,75,29,47
HERE;
        $this->assertEquals(143, $this->solve($input));
    }

    public function test_first_part()
    {
        $input = file_get_contents(__DIR__ . '/data/day5');
        $this->assertEquals(4774, $this->solve($input));
    }

    public function test_second_part_example()
    {
        $input = <<<HERE
47|53
97|13
97|61
97|47
75|29
61|13
75|53
29|13
97|29
53|29
61|53
97|53
61|29
47|13
75|47
97|75
47|61
75|61
47|29
75|13
53|13

75,97,47,61,53
61,13,29
97,13,75,29,47
HERE;
        $this->assertEquals(123, $this->solve($input, true));
    }

    public function test_second_part()
    {
        $input = file_get_contents(__DIR__ . '/data/day5');
        $this->assertEquals(6004, $this->solve($input, true));
    }
}