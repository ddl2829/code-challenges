<?php

function isPalindrome($s) {
    $lower = strtolower($s);
    $out = '';
    for($i = 0; $i < strlen($lower); $i++) {
        $chr = ord($lower[$i]);
        if(($chr >= 97 && $chr <= 122) || ($chr >= 48 && $chr <= 57)) {
            $out .= $lower[$i];
        }
    }
    $firstPos = 0;
    $lastPos = strlen($out) - 1;
    while($firstPos < $lastPos) {
        $char1 = $out[$firstPos];
        $char2 = $out[$lastPos];
        if($char1 !== $char2) {
            return false;
        }
        $firstPos++;
        $lastPos--;
    }
    return true;
}

print_r(isPalindrome("A man, a plan, a canal: Panama"));
echo "\n";
print_r(isPalindrome("race a car"));