<?php

// You are climbing a staircase. It takes n steps to reach the top.
//
// Each time you can either climb 1 or 2 steps. In how many distinct ways can you climb to the top?
/**
 * @param Integer $n
 * @return Integer
 */
function climbStairs($n, &$cache = []) {
    // if n = 3
    // 1, 1, 1
    // 1, 2
    // 2, 1

    if($n === 1) {
        return 1;
    } else if($n === 2) {
        return 2;
    } else if(isset($cache[$n])) {
        return $cache[$n];
    } else {
        $cache[$n] = climbStairs($n - 1, $cache) + climbStairs($n - 2, $cache);
        return $cache[$n];
    }
}

echo climbStairs(44) . PHP_EOL; // 2 ways
//echo climbStairs(3) . PHP_EOL; // 3 ways