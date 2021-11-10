<?php
// https://www.hackerrank.com/challenges/balanced-brackets/problem

function isBalanced($s) {
    while (true) {
        $lengthBefore = strlen($s);
        $s = str_replace('()', '', $s);
        $s = str_replace('[]', '', $s);
        $s = str_replace('{}', '', $s);
        if (strlen($s) == $lengthBefore) return 'NO';
        if (strlen($s) == 0) return 'YES';
    }
}
