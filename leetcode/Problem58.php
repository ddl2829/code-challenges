<?php


/**
 * @param String $s
 * @return Integer
 */
function lengthOfLastWord($s) {
    return strlen(end(@explode(" ", trim($s))));
}