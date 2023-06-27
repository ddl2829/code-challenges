<?php

/**
 * @param String $haystack
 * @param String $needle
 * @return Integer
 */
function str_str($haystack, $needle) {
    $len = strlen($haystack);
    $needleLen = strlen($needle);
    for($i = 0; $i < $len - $needleLen + 1; $i++) {
        for($j = 0; $j < $needleLen; $j++) {
            if($haystack[$i + $j] !== $needle[$j]) {
                continue 2;
            }
        }
        return $i;
    }
    return -1;
}

echo str_Str("sadbutsad", "sad") . PHP_EOL;