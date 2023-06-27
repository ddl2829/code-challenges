<?php


/**
 * @param Integer[] $nums1
 * @param Integer[] $nums2
 * @return Float
 */
function findMedianSortedArrays($nums1, $nums2) {
    $digits = count($nums1) + count($nums2);
    $isEven = $digits % 2 === 0;
    $seekIndex = $isEven ? ($digits / 2) + 1 : ceil($digits / 2);
    $merged = [];
    $i = 0;
    while(count($nums1) || count($nums2)) {
        if(empty($nums1)) {
            $merged[] = array_shift($nums2);
        } else if(empty($nums2)) {
            $merged[] = array_shift($nums1);
        } else {
            if($nums1[0] < $nums2[0]) {
                $merged[] = array_shift($nums1);
            } else {
                $merged[] = array_shift($nums2);
            }
        }
        $i++;
        if($i == $seekIndex) {
            if (!$isEven) {
                return array_pop($merged);
            } else {
                return (array_pop($merged) + array_pop($merged)) / 2;
            }
        }
    }
    return 0;
}

echo findMedianSortedArrays([1, 3], [2]);