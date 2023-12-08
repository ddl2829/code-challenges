<?php

namespace AdventOfCode2023;

use PHPUnit\Framework\TestCase;

class Day3 extends TestCase
{
    public function solve($input) {

        // surround input with a ring of "." so we dont need to check bounds in the loop
        $lines = explode("\n", $input);
        $lineLength = strlen($lines[0]);

        array_unshift($lines, str_repeat('.', $lineLength)); // add a line of .... at start of input
        array_push($lines, str_repeat('.', $lineLength)); // add a line of .... at end of input
        foreach($lines as &$line) {
            $line = ".$line."; // add a column of . at the start and end
        }

        echo "Buffered input:\n";
        echo implode("\n", $lines);

        $grid = [];
        foreach($lines as $row) {
            $grid[] = str_split($row);
        }

        $partNumbers = [];
        // for each line, find the index of any numbers
        // check the squares surrounding that number for symbols (anything that isnt a period or another number?)
        foreach($lines as $r => $row) {
            preg_match_all('/\d+/', $row, $matches, PREG_OFFSET_CAPTURE);
            //echo print_r($matches, true);
            foreach($matches[0] as $match) {
                $number = intval($match[0]);
                $matchLength = strlen($number);
                $index = intval($match[1]);

                echo "\n\nfound $number\n";

                $isPartNumber = false;
                // check the square of positions around the number
                for($checkRow = $r - 1; $checkRow <= $r + 1; $checkRow++) {
                    for($checkCol = $index - 1; $checkCol < $index + $matchLength + 1; $checkCol++) {
                        echo $grid[$checkRow][$checkCol];
                    }
                    echo "\n";
                }


                for($checkRow = $r - 1; $checkRow <= $r + 1; $checkRow++) {
                    for($checkCol = $index - 1; $checkCol < $index + $matchLength + 1; $checkCol++) {
                        //echo $grid[$checkRow][$checkCol];
                        // if we're looking at a period or our number, continue along
                        // if we find a symbol, add the number to the partNumbers list and move to the next number
                        if($grid[$checkRow][$checkCol] === ".") {
                            //echo " is period\n";
                        } else if(is_numeric($grid[$checkRow][$checkCol])) {
                            //echo " is number\n";
                        } else {
                            // must be a symbol
                            $isPartNumber = true;
                            //echo " is symbol";
                        }
                    }
                }

                if($isPartNumber) {
                    $partNumbers[] = $number;
                }
            }
        }

        //print_r($partNumbers);

        return array_sum($partNumbers);
    }

    public function solve2($input) {
        // surround input with a ring of "." so we dont need to check bounds in the loop
        $lines = explode("\n", $input);
        $lineLength = strlen($lines[0]);

        array_unshift($lines, str_repeat('.', $lineLength)); // add a line of .... at start of input
        array_push($lines, str_repeat('.', $lineLength)); // add a line of .... at end of input
        foreach($lines as &$line) {
            $line = ".$line."; // add a column of . at the start and end
        }

        echo "Buffered input:\n";
        echo implode("\n", $lines);
        echo "\n\n";

        $grid = [];
        foreach($lines as $row) {
            $grid[] = str_split($row);
        }

        $gearRatios = [];
        foreach($lines as $r => $row) {
            preg_match_all('/\*/', $row, $matches, PREG_OFFSET_CAPTURE);
            foreach($matches[0] as $match) {
                $index = intval($match[1]);
                $adjacentNumbers = [];
                for($checkRow = $r - 1; $checkRow <= $r + 1; $checkRow++) {
                    for($checkCol = $index - 1; $checkCol <= $index + 1; $checkCol++) {
                        echo $grid[$checkRow][$checkCol];
                        if(is_numeric($grid[$checkRow][$checkCol])) {
                            // get the full number this digit is part of
                            preg_match_all('/\d+/', $lines[$checkRow], $numberMatches, PREG_OFFSET_CAPTURE);
                            // get the last match with an offset before or equal to $checkCol
                            $numberMatches = $numberMatches[0];
                            foreach($numberMatches as $i => $m) {
                                if($m[1] <= $checkCol && (!isset($numberMatches[$i+1]) || $numberMatches[$i+1][1] > $checkCol)) {
                                    if(!in_array($m[0], $adjacentNumbers)) {
                                        //echo "found {$m[0]}\n";
                                        $adjacentNumbers[] = $m[0];
                                        break;
                                    }
                                }
                            }
                        }
                    }
                    echo "\n";
                }
                echo "\n\n";
                if(count($adjacentNumbers) === 2) {
                    //echo "found {$adjacentNumbers[0]} * {$adjacentNumbers[1]}\n";
                    $gearRatios[] = intval($adjacentNumbers[0]) * intval($adjacentNumbers[1]);
                }
            }
        }

        return array_sum($gearRatios);
    }

    public function test_first_part_example() {
        $input = <<<HERE
467..114..
...*......
..35..633.
......#...
617*......
.....+.58.
..592.....
......755.
...$.*....
.664.598..
HERE;
        $this->assertEquals(4361, $this->solve($input));
    }

    public function test_first_part() {
        $input = file_get_contents('data/day3');
        $this->assertEquals(539433, $this->solve($input));
    }

    public function test_second_part_example() {
        $input = <<<HERE
467..114..
...*......
..35..633.
......#...
617*......
.....+.58.
..592.....
......755.
...$.*....
.664.598..
HERE;
        $this->assertEquals(467835, $this->solve2($input));
    }

    public function test_second_part() {
        $input = file_get_contents('data/day3');
        $this->assertEquals(75847567, $this->solve2($input));
    }
}