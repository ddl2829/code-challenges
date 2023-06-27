<?php

//Given a non-negative integer x, return the square root of x rounded down to the nearest integer. The returned integer should be non-negative as well.
//
//You must not use any built-in exponent function or operator.

/**
 * @param Integer $x
 * @return Integer
 */
function mySqrt($x) {
    for($i = 1; $i < $x; $i++) {
        if($i * $i <= $x && ($i + 1) * ($i + 1) > $x) {
            return $i;
        }
    }
    return $x;
}

echo mySqrt(1) . PHP_EOL;