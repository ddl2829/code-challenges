<?php

// Given an integer array nums sorted in non-decreasing order, remove the duplicates in-place such that each unique element appears only once. The relative order of the elements should be kept the same. Then return the number of unique elements in nums.
//
// Consider the number of unique elements of nums to be k, to get accepted, you need to do the following things:
//
//    Change the array nums such that the first k elements of nums contain the unique elements in the order they were present in nums initially. The remaining elements of nums are not important as well as the size of nums.
//
//    Return k.


/**
 * @param Integer[] $nums
 * @return Integer
 */
function removeDuplicates(&$nums) {
    $writeIndex = 0;
    $numCount = count($nums);
    for($i = 0; $i < $numCount; $i++) {
        if($nums[$i] !== $nums[$writeIndex]) {
            $writeIndex++;
            $nums[$writeIndex] = $nums[$i];
        }
    }
    return $writeIndex + 1;
}

$nums = [0,0,1,1,1,2,2,3,3,4];
removeDuplicates($nums);
print_r($nums);