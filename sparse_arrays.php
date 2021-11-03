<?php
// https://www.hackerrank.com/challenges/sparse-arrays/problem

function matchingStrings($strings, $queries) {
    $result = [];
    $counts = array_count_values($strings);
    foreach ($queries as $query) {
        $result[] = $counts[$query] ?? 0;
    }
    return $result;
}
