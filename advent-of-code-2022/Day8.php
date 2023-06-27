<?php

require "../vendor/autoload.php";

/*


 */

$input = file_get_contents("data/day8");

$lines = explode("\n", $input);

$trees = collect($lines)->map(function($line) {
    return str_split($line);
});

function isTreeVisible($trees, $row, $column) {
    // get the height at x and y
    // the tree is visible if nothing in one of the cardinal directions is taller
    $treeHeight = $trees[$row][$column];

    // check the vertical column above this location
    $visibleTop = $visibleBottom = $visibleLeft = $visibleRight = true;
    for($y = 0; $y < $row; $y++) {
        if($trees[$y][$column] >= $treeHeight) {
            $visibleTop = false;
        }
    }

    // check the vertical column below this location
    for($y = $row + 1; $y < count($trees); $y++) {
        if($trees[$y][$column] >= $treeHeight) {
            $visibleBottom = false;
        }
    }

    // check the horizontal row left of this location
    for($x = 0; $x < $column; $x++) {
        if($trees[$row][$x] >= $treeHeight) {
            $visibleLeft = false;
        }
    }

    // check the horizontal row right of this location
    for($x = $column + 1; $x < count($trees[$row]); $x++) {
        if($trees[$row][$x] >= $treeHeight) {
            $visibleRight = false;
        }
    }

    return $visibleTop || $visibleBottom || $visibleRight || $visibleLeft;
}


$totalVisible = 0;
for($row = 0; $row < count($trees); $row++) {
    for($column = 0; $column < count($trees[$row]); $column++) {
        if(isTreeVisible($trees, $row, $column)) {
            $totalVisible++;
            echo "X";
        } else {
            echo ".";
        }
    }
    echo "\n";
}
echo $totalVisible . "\n\n";


function calculateScenicScore($trees, $row, $column) {
    $treeHeight = $trees[$row][$column];

    // check the vertical column above this location
    $topScore = $bottomScore = $leftScore = $rightScore = 0;

    $lastHeight = 0;
    for($y = $row - 1; $y >= 0; $y--) {
        $topScore++;
        if($trees[$y][$column] >= $lastHeight) {
            $lastHeight = $trees[$y][$column];
        }
        if($trees[$y][$column] >= $treeHeight) {
            break;
        }
    }
    //echo "top score for $row $column - $topScore \n";

    $lastHeight = 0;
    for($y = $row + 1; $y < count($trees); $y++) {
        $bottomScore++;
        if($trees[$y][$column] >= $lastHeight) {
            $lastHeight = $trees[$y][$column];
        }
        if($trees[$y][$column] >= $treeHeight) {
            break;
        }
    }

    $lastHeight = 0;
    for($x = $column - 1; $x >= 0; $x--) {
        $leftScore++;
        if($trees[$row][$x] >= $lastHeight) {
            $lastHeight = $trees[$row][$x];
        }
        if($trees[$row][$x] >= $treeHeight) {
            break;
        }
    }

    $lastHeight = 0;
    for($x = $column + 1; $x < count($trees[$row]); $x++) {
        $rightScore++;
        if($trees[$row][$x] >= $lastHeight) {
            $lastHeight = $trees[$row][$x];
        }
        if($trees[$row][$x] >= $treeHeight) {
            break;
        }
    }

    return $topScore * $bottomScore * $rightScore * $leftScore;
}



$bestScore = 0;
for($row = 0; $row < count($trees); $row++) {
    for($column = 0; $column < count($trees[$row]); $column++) {
        $score = calculateScenicScore($trees, $row, $column);

        if($score > $bestScore) {
            $bestScore = $score;
            echo $score . "\t";
        } else {
            echo "-\t";
        }
    }
    echo "\n";
}
echo $bestScore;