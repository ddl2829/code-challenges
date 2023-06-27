<?php

// Given a sorted array of distinct integers and a target value, return the index if the target is found. If not, return the index where it would be if it were inserted in order.
//
// You must write an algorithm with O(log n) runtime complexity.

/**
 * @param Integer[] $nums
 * @param Integer $target
 * @return Integer
 */
function searchInsert($nums, $target) {
    echo "Searching for $target in " . json_encode($nums) . PHP_EOL;
    $itemCount = count($nums);
    if($itemCount === 1) {
        if($nums[0] < $target) {
            return 1;
        } else {
            return 0;
        }
    }
    $middle = floor($itemCount / 2);

     if($nums[$middle] > $target) {
         return searchInsert(array_slice($nums, 0, $middle), $target);
     } else {
         return $middle + searchInsert(array_slice($nums, $middle), $target);
     }
}

$nums = [1,3,5];
echo searchInsert($nums, 4);