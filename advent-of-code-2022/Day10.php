<?php

require "../vendor/autoload.php";

$input = explode("\n", file_get_contents("data/day10"));

function run_commands($input) {
    $x = 1;
    foreach ($input as $command) {
        $cmd = explode(" ", $command);
        switch ($cmd[0]) {
            case 'noop':
                yield $x;
                break;
            case 'addx':
                yield $x;
                yield $x;
                $x += intval($cmd[1]);
                break;
        }
    }
    return false;
}

$cycle = 0;
$sumOn = [20, 60, 100, 140, 180, 220];
$xOut = [];
$pixel = 0;
foreach(run_commands($input) as $yielded) {
    $cycle++;

    if(in_array($pixel, [$yielded, $yielded - 1, $yielded + 1])) { // view console for part 2 answer
        echo "#";
    } else {
        echo '.';
    }
    $pixel++;
    if($pixel === 40) {
        $pixel = 0;
        echo "\n";
    }
    if(in_array($cycle, $sumOn)) {
        $xOut[] = $yielded * $cycle;
    }
}

echo array_sum($xOut); // part 1 answer
echo "\n";
print_r($xOut);