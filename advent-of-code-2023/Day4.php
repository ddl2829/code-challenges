<?php


namespace AdventOfCode2023;

use PHPUnit\Framework\TestCase;

class Day4 extends TestCase
{
    public function solve($input, $partTwo = false) {
        ini_set('memory_limit','4096M');
        $perCard = [];
        $lines = explode("\n", $input);
        $totalScore = 0;
        for($l = 0; $l < count($lines); $l++) {
            $line = $lines[$l];
            [$cardId, $numbers] = explode(": ", $line);
            $cardNum = intval(trim(str_replace("Card ", "", $cardId)));
            if(isset($perCard[$totalScore])) {
                for($q = $cardNum; $q < intval($cardNum) + $perCard[$totalScore]; $q++) {
                    $lines[] = $lines[$q];
                }
                continue;
            }
            [$list1, $list2] = explode(" | ", $numbers);
            $list1 = array_filter(explode(" ", $list1));
            $list2 = array_filter(explode(" ", $list2));
            $overlap = array_intersect($list1, $list2);

            $matches = count($overlap);
            $perCard[$cardId] = $matches;

            if($matches > 0) {
                if($partTwo) {
                    // add another copy of the next $matches cards to the list
                    for($q = $cardNum; $q < intval($cardNum) + $matches; $q++) {
                        //echo "\tadding to lines: $lines[$q]\n";
                        $lines[] = $lines[$q];
                    }
                    continue;
                }
                $cardScore = 1;
                $doubles = count($overlap) - 1;
                for($i = 0; $i < $doubles; $i++) {
                    $cardScore *= 2;
                }
                $totalScore += $cardScore;
            }

        }
        if($partTwo) {
            return count($lines);
        }
        return $totalScore;
    }

    public function test_first_part_example() {
        $input = <<<HERE
Card 1: 41 48 83 86 17 | 83 86  6 31 17  9 48 53
Card 2: 13 32 20 16 61 | 61 30 68 82 17 32 24 19
Card 3:  1 21 53 59 44 | 69 82 63 72 16 21 14  1
Card 4: 41 92 73 84 69 | 59 84 76 51 58  5 54 83
Card 5: 87 83 26 28 32 | 88 30 70 12 93 22 82 36
Card 6: 31 18 13 56 72 | 74 77 10 23 35 67 36 11
HERE;
        $this->assertEquals(13, $this->solve($input));
    }

    public function test_first_part() {
        $input = file_get_contents('data/day4');
        $this->assertEquals(27454, $this->solve($input));
    }

    public function test_second_part_example() {
        $input = <<<HERE
Card 1: 41 48 83 86 17 | 83 86  6 31 17  9 48 53
Card 2: 13 32 20 16 61 | 61 30 68 82 17 32 24 19
Card 3:  1 21 53 59 44 | 69 82 63 72 16 21 14  1
Card 4: 41 92 73 84 69 | 59 84 76 51 58  5 54 83
Card 5: 87 83 26 28 32 | 88 30 70 12 93 22 82 36
Card 6: 31 18 13 56 72 | 74 77 10 23 35 67 36 11
HERE;
        $this->assertEquals(30, $this->solve($input, true));
    }

    public function test_second_part() {
        $input = file_get_contents('data/day4');
        $this->assertEquals(6857330, $this->solve($input, true));
    }
}