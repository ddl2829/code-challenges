<?php

require "../vendor/autoload.php";

/*


 */

$input = file_get_contents("data/day9");

$lines = collect(explode("\n", $input))->map(function($row) {
    return explode(" ", $row);
});

$visited = [];

$headX = 100;
$headY = 100;

$tailX = 100;
$tailY = 100;

function isTailAdjacent($headX, $headY, $tailX, $tailY) {
    if($headX === $tailX - 1 && $headY === $tailY - 1) { // head is upper left of tail
        return true;
    }
    if($headX === $tailX && $headY === $tailY - 1) { // head is above tail
        return true;
    }
    if($headX === $tailX + 1 && $headY === $tailY - 1) { // head is above tail to right
        return true;
    }

    if($headX === $tailX - 1 && $headY === $tailY) { // head is to the left
        return true;
    }
    if($headX === $tailX && $headY === $tailY) { // head is on tail
        return true;
    }
    if($headX === $tailX + 1 && $headY === $tailY) { // head is right of tail
        return true;
    }

    if($headX === $tailX - 1 && $headY === $tailY + 1) { // head is below tail to left
        return true;
    }
    if($headX === $tailX && $headY === $tailY + 1) { // head is below tail
        return true;
    }
    if($headX === $tailX + 1 && $headY === $tailY + 1) { // head is below tail to right
        return true;
    }

    return false;
}

function isTailCardinal($headX, $headY, $tailX, $tailY) {
    if($headX === $tailX || $headY === $tailY) {
        return [$headX - $tailX, $headY - $tailY];
    }

    return false;
}

$visited['100/100'] = true;

foreach($lines as $line) {
    $direction = $line[0];
    $distance = $line[1];

    for($i = 0; $i < $distance; $i++) {
        $prevHeadX = $headX;
        $prevHeadY = $headY;

        // move the head
        switch ($direction) {
            case 'U':
                $headY--;
                break;
            case 'L':
                $headX--;
                break;
            case 'R':
                $headX++;
                break;
            case 'D':
                $headY++;
                break;
        }
        // if the tail is still adjacent, do nothing
        if (!isTailAdjacent($headX, $headY, $tailX, $tailY)) {
            // otherwise, it should follow the head's previous position
            $tailX = $prevHeadX;
            $tailY = $prevHeadY;
        }

        $visited["$tailX/$tailY"] = true;
    }
}

echo count($visited);
echo "\n\n";


function renderRope($rope) {
    $xSpread = [9999999999, -999999999];
    $ySpread = [9999999999, -999999999];
    foreach($rope as $segment) {
        if($segment['x'] < $xSpread[0]) {
            $xSpread[0] = $segment['x'];
        }
        if($segment['x'] > $xSpread[1]) {
            $xSpread[1] = $segment['x'];
        }
        if($segment['y'] < $ySpread[0]) {
            $ySpread[0] = $segment['y'];
        }
        if($segment['y'] > $ySpread[1]) {
            $ySpread[1] = $segment['y'];
        }
    }
    for($y = $ySpread[0]; $y <= $ySpread[1]; $y++) {
        for($x = $xSpread[0]; $x <= $xSpread[1]; $x++) {
            foreach($rope as $index => $segment) {
                if($segment['x'] === $x && $segment['y'] === $y) {
                    echo $index;
                    continue 2;
                }
            }
            echo ".";
        }
        echo "\n";
    }
}

// part 2

// generalize the above for n rope segments vs just head/tail
$startX = 0;
$startY = 0;
$rope = array_fill_keys(range(0, 9), ['x' => $startX, 'y' => $startY]);
$visited = [];
$visited["0/0"] = true;

foreach($lines as $line) {
    $direction = $line[0];
    $distance = $line[1];

    for($i = 0; $i < $distance; $i++) {
        foreach($rope as $index => &$segment) {
            $segment['previousX'] = $segment['x'];
            $segment['previousY'] = $segment['y'];

            if($index === 0) {
                // move the head
                switch ($direction) {
                    case 'U':
                        $segment['y']--;
                        break;
                    case 'L':
                        $segment['x']--;
                        break;
                    case 'R':
                        $segment['x']++;
                        break;
                    case 'D':
                        $segment['y']++;
                        break;
                }
            }

            if($index > 0) {
                $previous = $rope[$index - 1];
                // if this segment is still adjacent to the previous segment, do nothing
                if (!isTailAdjacent($previous['x'], $previous['y'], $segment['x'], $segment['y'])) {
                    if(($offset = isTailCardinal($previous['x'], $previous['y'], $segment['x'], $segment['y'])) !== false) {
                        if($offset[0] > 0) {
                            $segment['x']++;
                        } else if($offset[0] < 0) {
                            $segment['x']--;
                        }
                        if($offset[1] > 0) {
                            $segment['y']++;
                        } else if($offset[1] < 0) {
                            $segment['y']--;
                        }
                    } else {
                        // must move diagonally to follow the previous segment
                        if($previous['x'] > $segment['x']) {
                            // we're gonna move right
                            $segment['x']++;
                        } else {
                            // we're gonna move left
                            $segment['x']--;
                        }
                        if($previous['y'] > $segment['y']) {
                            // we're gonna move down
                            $segment['y']++;
                        } else {
                            // we're gonna move up
                            $segment['y']--;
                        }
                    }
                }

                if ($index === 9) {
                    $visited["{$segment['x']}/{$segment['y']}"] = true;
                    //echo $line[0] . " " . $line[1] . "\n";
                    //renderRope($rope);
                }
            }
        }
    }
}

echo count($visited);

echo "\n";

// draw map of visited positions

$visitedCoords = array_keys($visited);
$v = array_map(function($coord) {
    return explode('/', $coord);
}, $visitedCoords);

$minX = collect($v)->map(function($coord) {
    return $coord[0];
})->min();

$maxX = collect($v)->map(function($coord) {
    return $coord[0];
})->max();

$minY = collect($v)->map(function($coord) {
    return $coord[1];
})->min();

$maxY = collect($v)->map(function($coord) {
    return $coord[1];
})->max();

for($y = $minY; $y <= $maxY; $y++) {
    for($x = $minX; $x <= $maxX; $x++) {
        if(array_key_exists("$x/$y", $visited)) {
            echo "#";
        } else {
            echo ".";
        }
    }
    echo "\n";
}