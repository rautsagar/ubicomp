<?php

function calculate_used_time($startTime, $endTime, $intervalStartTime, $intervalEndTime)
{
    $startTime = strtotime($startTime);
    $endTime = strtotime($endTime);
    $intervalStartTime = strtotime($intervalStartTime);
    $intervalEndTime = strtotime($intervalEndTime);
    
    if($endTime < $intervalStartTime)
    {
        $used = 0;
    }
    else if($startTime > $intervalEndTime)
    {
        $used = 0;
    }
    else if($startTime < $intervalStartTime && $endTime > $intervalEndTime)
    {
        $used = 100;
    }
    else if($startTime >= $intervalStartTime && $endTime < $intervalEndTime)
    {
        $used = 100 * ($endTime - $startTime)/($intervalEndTime - $intervalStartTime);
    }
    else if($startTime <= $intervalStartTime && $endTime < $intervalEndTime)
    {
        $used = 100 * ($endTime - $intervalStartTime)/($intervalEndTime - $intervalStartTime);
    }
    else if($startTime >= $intervalStartTime && $endTime > $intervalEndTime)
    {
        $used = 100 * ($intervalEndTime - $startTime)/($intervalEndTime - $intervalStartTime);
    }
    else
    {
        $used = 0;
    }
    
    return $used;
}

?>
