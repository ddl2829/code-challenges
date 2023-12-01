<?php


function merge(&$nums1, $m, $nums2, $n) {
    $j = 0;
    for($i = 0; $i < $m + $n; $i++) {
        if(!isset($nums2[$j])) {
            break;
        }
        if($nums1[$i] > $nums2[$j] || $nums1[$i] === 0) {
            $tmp = $nums1[$i];
            $nums1[$i] = $nums2[$j];
            $nums2[$j] = $tmp;
            if($tmp === 0) {
                $j++;
            }
        }
    }
}


$m = [1,2,3,0,0,0];
$n = [2,5,6];

merge($m, 3, $n, 3);
echo implode(",", $m);