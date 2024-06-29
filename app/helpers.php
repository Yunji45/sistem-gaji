<?php
use Illuminate\Support\Facades\Auth;

function getDateNowParse()
{
    return date_parse(now());
}

function getUserId()
{
    return Auth::user()->id;
}
function countDays($year, $month, $ignore)
{
    $count = 0;
    $counter = mktime(0, 0, 0, $month, 1, $year);
    while (date('n', $counter) == $month) {
        if (in_array(date('w', $counter), $ignore) == false) {
            $count++;
        }
        $counter = strtotime('+1 day', $counter);
    }
    return $count;
    // echo countDays(2013, 1, array(0, 6)); // 23
}
function weekdays()
{
    $date = getDateNowParse();
    return countDays($date['year'], $date['month'], [0, 6]);
}
