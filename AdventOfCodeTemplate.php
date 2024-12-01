<?php


use PHPUnit\Framework\TestCase;

class AdventOfCodeTemplate extends TestCase
{
    public function solve($input, $partTwo = false) {
        return 0;
    }

    public function test_first_part_example() {
        $input = <<<HERE

HERE;
        $this->assertEquals("", $this->solve($input));
    }

    public function test_first_part() {
        $input = file_get_contents(__DIR__ . '/data/day1');
        $this->assertEquals("", $this->solve($input));
    }

    public function test_second_part_example() {
        $input = <<<HERE

HERE;
        $this->assertEquals("", $this->solve($input, true));
    }

    public function test_second_part() {
        $input = file_get_contents(__DIR__ . '/data/day1');
        $this->assertEquals("", $this->solve($input, true));
    }
}