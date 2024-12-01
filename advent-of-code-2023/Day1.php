<?php

namespace AdventOfCode2023;

class Day1 extends \PHPUnit\Framework\TestCase {

    public $mappings = [
        'one' => 1,
        'two' => 2,
        'three' => 3,
        'four' => 4,
        'five' => 5,
        'six' => 6,
        'seven' => 7,
        'eight' => 8,
        'nine' => 9,
    ];

    public function getFirstNumber($line, $convertDigits = false) {
        if (is_numeric($line[0])) {
            return $line[0];
        }
        if($convertDigits) {
            $index = 0;
            while ($index < strlen($line) - 1) {
                if (is_numeric($line[$index])) {
                    return $line[$index];
                }
                foreach ($this->mappings as $word => $replacement) {
                    $substr = substr($line, $index, strlen($word));
                    if ($substr === $word) {
                        return $replacement;
                    }
                }
                $index++;
            }
        }

        $digits = str_split(preg_replace('/[a-zA-Z]/', '', $line));
        return $digits[0];
    }

    public function getLastNumber($line, $convertDigits = false) {
        if(is_numeric($line[strlen($line) - 1])) {
            return $line[strlen($line) - 1];
        }
        if($convertDigits) {
            $index = strlen($line) - 1;
            while ($index >= 0) {
                if (is_numeric($line[$index])) {
                    return $line[$index];
                }
                foreach ($this->mappings as $word => $replacement) {
                    $substr = substr($line, $index, strlen($word));
                    if ($substr === $word) {
                        return $replacement;
                    }
                }
                $index--;
            }
        }

        $digits = str_split(preg_replace('/[a-zA-Z]/', '', $line));
        return $digits[count($digits) - 1];

    }

    public function solveProblem($input, $secondPart = false) {
        // get the 2 digit numbers from each line (first digit and last digit)
        $numbers = [];
        $lines = explode("\n", $input);
        foreach($lines as $line) {
            $firstNumber = $this->getFirstNumber($line, $secondPart);
            $lastNumber = $this->getLastNumber($line, $secondPart);
            $number = "{$firstNumber}{$lastNumber}";
            $numbers[] = $number;
        }
        return array_sum($numbers);
    }

    public function test_first_part_example() {
        $input = <<<EOT
1abc2
pqr3stu8vwx
a1b2c3d4e5f
treb7uchet
EOT;
        $this->assertEquals(142, $this->solveProblem($input));
    }

    public function test_first_part() {
        $input = file_get_contents(__DIR__ . '/data/day1');
        $this->assertEquals(54951, $this->solveProblem($input));
    }

    public function test_second_part_example() {
        $input = <<<EOT
two1nine
eightwothree
abcone2threexyz
xtwone3four
4nineeightseven2
zoneight234
7pqrstsixteen
EOT;

        $this->assertEquals(281, $this->solveProblem($input, true));
    }

    public function test_second_part() {
        $input = file_get_contents(__DIR__ . '/data/day1');
        $this->assertEquals(55218, $this->solveProblem($input, true));
    }
}