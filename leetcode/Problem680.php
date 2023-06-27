<?php

class Solution {

    public $startFrom = 0;

    /**
     * @param String $s
     * @return Boolean
     */
    function validPalindrome($s) {
        $len = strlen($s);
        $index = $this->isPalindrome($s, -1);
        if($index === -1) {
            return true;
        }
        $slice = substr($s, $index, $len - ($index * 2));
        $sliceLen = strlen($slice);
        // abccaba
        for($i = 0; $i < $sliceLen; $i++) {
            if($this->isPalindrome($slice, $i) === -1) {
                return true;
            }
        }
        return false;
    }

    function isPalindrome($out, $skipPosition) {
        $firstPos = 0;
        $lastPos = strlen($out) - 1;
        while($firstPos < $lastPos) {
            if($firstPos === $skipPosition) {
                $firstPos++;
            }
            if($lastPos === $skipPosition) {
                $lastPos--;
            }
            $char1 = $out[$firstPos];
            $char2 = $out[$lastPos];
            if($char1 !== $char2) {
                return $firstPos;
            }
            $firstPos++;
            $lastPos--;
        }
        return -1;
    }
}


$s = new Solution();
$s->validPalindrome("abca");