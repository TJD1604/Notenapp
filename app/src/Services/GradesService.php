<?php

namespace App\Services;



class GradesService{

    public function getAverage(array $nums){
        $sum = array_sum($nums);
        $count = count($nums);

        return round($sum/$count, 1, PHP_ROUND_HALF_UP);
    }



}