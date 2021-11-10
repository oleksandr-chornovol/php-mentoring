<?php
// https://www.hackerrank.com/challenges/2d-array/problem

function hourglassSum($arr) {
    $sums = [];
    for ($i = 0; $i < count($arr); $i++) {
        for ($j = 0; $j < count($arr[$i]); $j++) {
            if ($i + 2 < count($arr) && $j + 2 < count($arr[$i])) {
                $sums[] =
                    $arr[$i][$j] + $arr[$i][$j + 1] + $arr[$i][$j + 2]
                    + $arr[$i + 1][$j + 1]
                    + $arr[$i + 2][$j] + $arr[$i + 2][$j + 1] + $arr[$i + 2][$j + 2];
            }
        }
    }
    return max($sums);
}
