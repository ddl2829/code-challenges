<?php
class Solution {

    /**
     * @param String $s
     * @return Integer
     */
    function myAtoi($s) {
        preg_match("/\s*([\-\+]?)(\d+)/", $s, $matches);
        print_r($matches);
        $out = $matches[2];
        if($matches[1] === '-') {
            return $out * -1;
        }
        return $out;
    }
}

$s = new Solution();
$s->myAtoi("42");