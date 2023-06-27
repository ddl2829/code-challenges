<?php

//Given two binary strings a and b, return their sum as a binary string.

/**
 * @param String $a
 * @param String $b
 * @return String
 */
function addBinary($a, $b) {
    $maxLen = max(strlen($a), strlen($b));
    $revA = str_pad(strrev($a), $maxLen, "0", STR_PAD_RIGHT);
    $revB = str_pad(strrev($b), $maxLen, "0", STR_PAD_RIGHT);
    $out = "";
    $carry = 0;
    for($i = 0; $i < $maxLen; $i++) {
        if($revA[$i] === "1" && $revB[$i] === "1") {
            if($carry === 1) {
                $out .= "1";
            } else {
                $out .= "0";
            }
            $carry = 1;
            continue;
        }
        if($revA[$i] === "1" || $revB[$i] === "1") {
            if($carry === 1) {
                $out .= "0";
                $carry = 1;
            } else {
                $out .= "1";
                $carry = 0;
            }
            continue;
        }
        $out .= $carry ? "1" : "0";
        $carry = 0;
    }
    if($carry) {
        $out .= "1";
    }
    return strrev($out);
}

echo addBinary("11", "1") . PHP_EOL;
echo addBinary("1010", "1011") . PHP_EOL;