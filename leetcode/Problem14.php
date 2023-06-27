<?php

function longestCommonPrefix($strs) {
    $prefix = '';
    $currentIndex = 0;

    while(true) {
        $currentChar = $strs[0][$currentIndex];
        foreach ($strs as $str) {
            if(strlen($str) < $currentIndex + 1) {
                break 2;
            }
            if($str[$currentIndex] !== $currentChar) {
                break 2;
            }
        }
        $prefix .= $currentChar;
        $currentIndex++;
    }
    return $prefix;
}

echo longestCommonPrefix(["flower","flow","flight"]) . "\n";