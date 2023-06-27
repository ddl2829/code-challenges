<?php

// You are given a large integer represented as an integer array digits, where each digits[i] is the ith digit of the integer.
// The digits are ordered from most significant to least significant in left-to-right order. The large integer does not contain any leading 0's.
//
// Increment the large integer by one and return the resulting array of digits.

/**
 * @param Integer[] $digits
 * @return Integer[]
 */
function plusOne($digits) {
    $lastDigitIndex = count($digits) - 1;
    for($i = $lastDigitIndex; $i >= 0; $i--) {
        if($digits[$i] === 9) {
            $digits[$i] = 0;
        } else {
            $digits[$i]++;
            return $digits;
        }
    }
    array_unshift($digits, 1);
    return $digits;
}


print_r(plusOne([1,2,3])) . PHP_EOL;
print_r(plusOne([9])) . PHP_EOL;
print_r(plusOne([9, 9, 9])) . PHP_EOL;