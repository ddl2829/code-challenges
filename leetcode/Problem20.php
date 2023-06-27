<?php

// Given a string s containing just the characters '(', ')', '{', '}', '[' and ']', determine if the input string is valid.
function isValid($s) {
    $pairs = [
        '(' => ')',
        '{' => '}',
        '[' => ']',
    ];
    $open = [];
    $size = 0;
    for($i = 0; $i < strlen($s); $i++) {
        $char = $s[$i];
        if(array_key_exists($char, $pairs)) {
            $open[] = $char;
            $size++;
            continue;
        }
        if(empty($open)) {
            return false;
        }
        // get the last thing in the open stack, this character must match it
        $lastOpen = $open[$size - 1];
        if($char !== $pairs[$lastOpen]) {
            return false;
        }
        array_pop($open);
        $size--;
    }
    return $size === 0;
}

echo isValid("()") ? 'True' : 'False' . "\n";
echo isValid("()[]{}") ? 'True' : 'False' . "\n";
echo isValid("(]") ? 'True' : 'False' . "\n";