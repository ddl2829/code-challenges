<?php

require "../vendor/autoload.php";

$monkeyInputs = explode("\n\n", file_get_contents("data/day11"));

$monkeys = [];
$scalingFactor = 0;
foreach($monkeyInputs as $i) {
    $lines = explode("\n", $i);
    preg_match('/Operation: new = old ([\*\+]) (.+)/', $lines[2], $operation);
    preg_match('/Test: divisible by (\d+)/', $lines[3], $test);
    preg_match('/If true: throw to monkey (\d+)/', $lines[4], $ifTrue);
    preg_match('/If false: throw to monkey (\d+)/', $lines[5], $ifFalse);
    $monkeys[] = [
        'inventory' => explode(", ", str_replace("  Starting items: ", '', $lines[1])),
        'operation' => $operation[1],
        'operand' => $operation[2],
        'test' => $test[1],
        'true' => $ifTrue[1],
        'false' => $ifFalse[1],
        'inspections' => 0
    ];
    if($scalingFactor === 0) {
        $scalingFactor = $test[1];
    } else {
        $scalingFactor *= $test[1];
    }
}

$rounds = 10000; // change to 20 rounds for part 1

for($r = 1; $r <= $rounds; $r++) {
    foreach($monkeys as &$monkey) {
        foreach($monkey['inventory'] as $itemIndex => $item) {
            $monkey['inspections']++;
            $worryLevel = $item;
            switch($monkey['operation']) {
                case '+':
                    $worryLevel = bcadd($worryLevel, $monkey['operand'] === 'old' ? $worryLevel : $monkey['operand']);
                    break;
                case '*':
                    $worryLevel = bcmul($worryLevel, $monkey['operand'] === 'old' ? $worryLevel : $monkey['operand']);
                    break;
            }
            // $testResult = bcmod($worryLevel / 3, $monkey['test']); // uncomment for part 1, comment out next line
            $testResult = bcmod($worryLevel, $monkey['test']);
            if(intval($testResult) === 0) {
                $monkeys[$monkey['true']]['inventory'][] = $worryLevel % $scalingFactor;
            } else {
                $monkeys[$monkey['false']]['inventory'][] = $worryLevel % $scalingFactor;
            }
            unset($monkey['inventory'][$itemIndex]);
        }
    }

    //echo "After round $r:\n";
    //foreach($monkeys as $index => $m) {
    //    echo "Monkey $index: " . implode(', ', $m['inventory']) . "\n";
    //}

    //echo "\n\n";
}

foreach($monkeys as  $i => $mm) {
    echo "Monkey $i inspected items {$mm['inspections']} times\n";
}

$topTwo = collect($monkeys)->sortByDesc('inspections')->slice(0, 2)->values()->toArray();

echo $topTwo[0]['inspections'] * $topTwo[1]['inspections'];