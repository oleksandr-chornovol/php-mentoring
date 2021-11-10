<?php
// https://www.hackerrank.com/challenges/truck-tour/problem

function truckTour($pumps) {
    $pumpsCount = count($pumps);
    $pumps = array_merge($pumps, $pumps);
    for ($i = 0; $i < $pumpsCount; $i++) {
        $tank = 0;
        for($j = $i; $j < $i + $pumpsCount; $j++) {
            $tank += $pumps[$j][0];
            if ($j == ($i + $pumpsCount - 1)) return $i;
            if ($tank < $pumps[$j][1]) break;
            $tank -= $pumps[$j][1];
        }
    }
}
