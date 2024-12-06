<?php


namespace AdventOfCode2023;

use PHPUnit\Framework\TestCase;

class Day6 extends TestCase
{
    public function solve($input, $partTwo = false) {
        $lines = explode("\n", $input);
        $times = $lines[0];
        $distances = $lines[1];
        $times = array_filter(explode(" ", $times));
        $distances = array_filter(explode(" ", $distances));
        array_shift($times);
        array_shift($distances);
        $times = array_map('intval', $times);
        $distances = array_map('intval', $distances);

        $races = count($times);
        $options = [];
        $op = 0;
        for($i = 0; $i < $races; $i++) {
            $opt = [];
            $raceTime = $times[$i];
            $raceDistance = $distances[$i];
            for($t = 1; $t < $raceTime; $t++) {
                if(($raceTime - $t) * $t > $raceDistance) {
                    if(!$partTwo) {
                        $opt[] = [$t, $raceTime - $t, ($raceTime - $t) * $t];
                    }
                    $op++;
                }
            }
            $options[] = $opt;
        }

        if($partTwo) {
            return $op;
        }

        return array_reduce($options, function($carry, $waysToWin) {
            return $carry * count($waysToWin);
        }, 1);
    }

    public function test_first_part_example() {
        $input = <<<HERE
Time:      7  15   30
Distance:  9  40  200
HERE;
        $this->assertEquals(288, $this->solve($input));
    }

    public function test_first_part() {
        $input = <<<HERE
Time:        50     74     86     85
Distance:   242   1017   1691   1252
HERE;

        $this->assertEquals(1731600, $this->solve($input));
    }

    public function test_second_part_example() {
        $input = <<<HERE
Time:      71530
Distance:  940200
HERE;
        $this->assertEquals(71503, $this->solve($input, true));
    }

    public function test_second_part() {
        ini_set('memory_limit','4096M');
        $input = <<<HERE
Time:        50748685
Distance:   242101716911252
HERE;
        $this->assertEquals(40087680, $this->solve($input, true));
    }
}