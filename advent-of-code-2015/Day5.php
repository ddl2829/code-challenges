<?php


namespace AdventOfCode2015;

use PHPUnit\Framework\TestCase;

class Day5 extends TestCase
{
    private function isNice($string) {
        // must contain 3 vowels
        // must contain a repeating character
        // must not contain ab, cd, pq, xy
        if(preg_match("/ab|cd|pq|xy/", $string)) {
            return false;
        }

        if(!preg_match('/(.*[aeiuo].*){3,}/', $string)) {
            return false;
        }

        for($i = 0; $i < strlen($string) - 1; $i++) {
            if($string[$i] === $string[$i+1]) {
                return true;
            }
        }
        return false;
    }

    private function isNice2($string) {
        // must contain a repeating pair
        // must have a letter that repeats with something between
        $hasRepeatingPair = false;
        for($i = 0; $i < strlen($string) - 1; $i++) {
            // take this and the next character, scan the string for the same combo again
            $subs = substr($string, $i, 2);
            for($j = $i + 2; $j < strlen($string) - 1; $j++) {
                $subs2 = substr($string, $j, 2);
                if($subs === $subs2) {
                    $hasRepeatingPair = true;
                    break 2;
                }
            }
        }
        if(!$hasRepeatingPair) {
            return false;
        }


        for($i = 0; $i < strlen($string) - 2; $i++) {
            // 2 characters from here should be the same
            if($string[$i+2] === $string[$i]) {
                return true;
            }
        }
        return false;
    }

    public function solve($input, $partTwo = false) {
        $lines = explode("\n", $input);
        $niceLines = 0;
        foreach($lines as $line) {
            $nice = $partTwo ? $this->isNice2($line) : $this->isNice($line);
            if($nice) {
                $niceLines++;
            }
        }
        return $niceLines;
    }

    public function test_first_part_example() {
        $this->assertEquals(true, $this->isNice("ugknbfddgicrmopn"));
        $this->assertEquals(true, $this->isNice("aaa"));

        $this->assertEquals(false, $this->isNice("jchzalrnumimnmhp"));
        $this->assertEquals(false, $this->isNice("haegwjzuvuyypxyu"));
        $this->assertEquals(false, $this->isNice("dvszwmarrgswjxmb"));
    }

    public function test_first_part() {
        $input = file_get_contents('data/day5');
        $this->assertEquals(255, $this->solve($input));
    }

    public function test_second_part_example() {
        $this->assertEquals(true, $this->isNice2("qjhvhtzxzqqjkmpb"));
        $this->assertEquals(true, $this->isNice2("xxyxx"));
        $this->assertEquals(false, $this->isNice2("uurcxstgmygtbstg"));
        $this->assertEquals(false, $this->isNice2("ieodomkazucvgmuy"));
    }

    public function test_second_part() {
        $input = file_get_contents('data/day5');
        $this->assertEquals(55, $this->solve($input, true));
    }
}