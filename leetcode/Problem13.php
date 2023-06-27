<?php


function romanToInt($s) {
    $firstTwo = substr($s, 0, 2);
    if($firstTwo === 'IV') {
        return 4 + romanToInt(substr($s, 2));
    } else if($firstTwo === 'IX') {
        return 9 + romanToInt(substr($s, 2));
    } else if($firstTwo === 'XL') {
        return 40 + romanToInt(substr($s, 2));
    } else if($firstTwo === 'XC') {
        return 90 + romanToInt(substr($s, 2));
    } else if($firstTwo === 'CD') {
        return 400 + romanToInt(substr($s, 2));
    } else if($firstTwo === 'CM') {
        return 900 + romanToInt(substr($s, 2));
    } else if($s[0] === 'I') {
        return 1 + romanToInt(substr($s, 1));
    } else if($s[0] === 'V') {
        return 5 + romanToInt(substr($s, 1));
    } else if($s[0] === 'X') {
        return 10 + romanToInt(substr($s, 1));
    } else if($s[0] === 'L') {
        return 50 + romanToInt(substr($s, 1));
    } else if($s[0] === 'C') {
        return 100 + romanToInt(substr($s, 1));
    } else if($s[0] === 'D') {
        return 500 + romanToInt(substr($s, 1));
    } else if($s[0] === 'M') {
        return 1000 + romanToInt(substr($s, 1));
    }
}

echo romanToInt("III") . "\n";
echo romanToInt("XXIV") . "\n";
echo romanToInt("MCMXCIV") . "\n";