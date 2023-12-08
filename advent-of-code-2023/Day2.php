<?php

namespace AdventOfCode2023;

use PHPUnit\Framework\TestCase;

class Day2 extends TestCase
{
    public function solve($input) {
        $lines = explode("\n", $input);

        $maxPerColor = [
            'red' => 12,
            'green' => 13,
            'blue' => 14
        ];

        $possibleGames = [];
        foreach($lines as $line) {
            [$game, $rolls] = explode(": ", $line);
            [$_, $gameId] = explode(" ", $game);
            $hands = explode("; ", $rolls);
            foreach($hands as $hand) {
                $roll = explode(", ", $hand);
                foreach($roll as $die) {
                    [$num, $color] = explode(" ", $die);
                    if($num > $maxPerColor[$color]) {
                        continue 3;
                    }
                }
            }
            $possibleGames[] = $gameId;
        }

        return array_sum($possibleGames);
    }

    public function solve2($input) {
        $lines = explode("\n", $input);

        $totalPower = 0;
        foreach($lines as $line) {
            $minPerColor = [
                'red' => 0,
                'green' => 0,
                'blue' => 0
            ];
            [$game, $rolls] = explode(": ", $line);
            $hands = explode("; ", $rolls);
            foreach($hands as $hand) {
                $roll = explode(", ", $hand);
                foreach($roll as $die) {
                    [$num, $color] = explode(" ", $die);
                    if($num > $minPerColor[$color]) {
                        $minPerColor[$color] = $num;
                    }
                }
            }
            $power = $minPerColor['green'] * $minPerColor['blue'] * $minPerColor['red'];
            $totalPower += $power;
        }

        return $totalPower;
    }

    public function test_first_part_example() {
        $input = <<<HERE
Game 1: 3 blue, 4 red; 1 red, 2 green, 6 blue; 2 green
Game 2: 1 blue, 2 green; 3 green, 4 blue, 1 red; 1 green, 1 blue
Game 3: 8 green, 6 blue, 20 red; 5 blue, 4 red, 13 green; 5 green, 1 red
Game 4: 1 green, 3 red, 6 blue; 3 green, 6 red; 3 green, 15 blue, 14 red
Game 5: 6 red, 1 blue, 3 green; 2 blue, 1 red, 2 green
HERE;
        $this->assertEquals(8, $this->solve($input));
    }

    public function test_first_part() {
        $input = file_get_contents('data/day2');
        $this->assertEquals(2720, $this->solve($input, true));
    }

    public function test_second_part_example() {
        $input = <<<HERE
Game 1: 3 blue, 4 red; 1 red, 2 green, 6 blue; 2 green
Game 2: 1 blue, 2 green; 3 green, 4 blue, 1 red; 1 green, 1 blue
Game 3: 8 green, 6 blue, 20 red; 5 blue, 4 red, 13 green; 5 green, 1 red
Game 4: 1 green, 3 red, 6 blue; 3 green, 6 red; 3 green, 15 blue, 14 red
Game 5: 6 red, 1 blue, 3 green; 2 blue, 1 red, 2 green
HERE;

        $this->assertEquals(2286, $this->solve2($input));
    }

    public function test_second_part() {
        $input = file_get_contents('data/day2');
        $this->assertEquals(71535, $this->solve2($input));
    }
}