<?php

require "../vendor/autoload.php";

$map = collect(explode("\n", file_get_contents("data/day12")))->map(function($row) {
    return str_split($row);
})->toArray(); // map is now a 2d array

// find fewest steps between S and E moving at most one step up (infinite down) at a time

$start = null;
$end = null;

// find the starting position
foreach($map as $rowIndex => $row) {
    foreach($row as $colIndex => $col) {
        if($col === "S") {
            $start = [$rowIndex, $colIndex, 'path' => ' '];
        }
        if($col === 'E') {
            $end = [$rowIndex, $colIndex, 'path' => ' '];
        }
    }
}

function getCandidateNeighbors(&$currentLocation, $map, $end) {
    $neighbors = [];
    $row = $currentLocation[0];
    $col = $currentLocation[1];
    $currentSymbol = $map[$row][$col];
    if($currentSymbol === 'S') {
        $currentSymbol = chr(ord('a') - 1);
    }

    if($row > 0 && ord($map[$row - 1][$col]) <= ord($currentSymbol) + 1) {
        if($map[$row - 1][$col] !== 'E' || $currentSymbol === 'z') {
            $neighbors[] = [$row - 1, $col, 'parent' => &$currentLocation, 'path' => $currentLocation['path'] . ' ' . ($row - 1) . ',' . $col . ' '];
        }
    }
    if($row < count($map) - 1 && ord($map[$row + 1][$col]) <= ord($currentSymbol) + 1) {
        if($map[$row + 1][$col] !== 'E' || $currentSymbol === 'z') {
            $neighbors[] = [$row + 1, $col, 'parent' => &$currentLocation, 'path' => $currentLocation['path'] . ' ' . ($row + 1) . ',' . $col . ' '];
        }
    }
    if($col > 0 && ord($map[$row][$col - 1]) <= ord($currentSymbol) + 1) {
        if($map[$row][$col - 1] !== 'E' || $currentSymbol === 'z') {
            $neighbors[] = [$row, $col - 1, 'parent' => &$currentLocation, 'path' => $currentLocation['path'] . ' ' . ($row) . ',' . ($col - 1) . ' '];
        }
    }
    if($col < count($map[$row]) - 1 && ord($map[$row][$col + 1]) <= ord($currentSymbol) + 1) {
        if($map[$row][$col + 1] !== 'E' || $currentSymbol === 'z') {
            $neighbors[] = [$row, $col + 1, 'parent' => &$currentLocation, 'path' => $currentLocation['path'] . ' ' . ($row) . ',' . ($col + 1) . ' '];
        }
    }

    $neighbors = collect($neighbors)->filter(function($n) {
        return !str_contains($n['parent']['path'], ' '. $n[0].','.$n[1] . ' ');
    })->map(function($n) use($end) {
        // prioritize n closer to the destination to check first
        $n['distance'] = pow(abs($n[0] - $end[0]), 2) + pow(abs($n[1] - $end[1]), 2);
        return $n;
    })->sortByDesc('distance');

    //print_r($neighbors);

    return $neighbors->values()->toArray();
}

echo "starting at " . implode(",", $start) . "\n";
echo "target at " . implode(",", $end) . "\n";

$start['parent'] = null;

// create a tree of all possible paths from S to E
$start['children'] = getCandidateNeighbors($start, $map, $end);
/**
 * @param mixed $parentNode
 * @param \Illuminate\Support\Collection $map
 * @return array
 */
function processNode(mixed &$parentNode, $map, &$pathsToE, $step, $end) {
    echo $parentNode[0] . "," . $parentNode[1] . "\n";
    $children = getCandidateNeighbors($parentNode, $map, $end);
    $parentNode['children'] = &$children;
    foreach ($children as &$child) {
        $symbol = $map[$child[0]][$child[1]];
        if ($symbol === 'E') {
            echo "Found the end\n";
            $path = [[$child[0], $child[1], $map[$child[0]][$child[1]]]];
            $steps = 0;
            // hooray we found the end
            $p = $child['parent'];
            while ($p !== null) {
                array_unshift($path, [$p[0], $p[1], $map[$p[0]][$p[1]]]);
                $steps++;
                $p = $p['parent'];
            }
            $pathsToE[] = ['path' => $path, 'steps' => $steps];
            continue;
        }
        // if we have a path to e, and it's less than our current step count, bail early
        if(count($pathsToE) > 0) {
            $shortestPath = (collect($pathsToE)->sortBy('steps')->first());
            if($step > $shortestPath['steps']) {
                echo "shorter path found, bailing";
                break;
            }
        }
        processNode($child, $map, $pathsToE, $step + 1, $end);
        //break;
        //$child['children'] = &$cc;
    }
}

$pathsToE = [];
processNode($start, $map, $pathsToE, 0, $end);


//print_r($start);
//return;

$shortestPath = (collect($pathsToE)->sortBy('steps')->first());

print_r($shortestPath);

for($r = 0; $r < count($map); $r++) {
    for($c = 0; $c < count($map[$r]); $c++) {
        // is it in the path?
        $found = false;
        foreach($shortestPath['path'] as $loc) {
            if($loc[0] === $r && $loc[1] === $c) {
                $found = true;
                break;
            }
        }
        echo $found ? "x" : ".";
    }
    echo "\n";
}