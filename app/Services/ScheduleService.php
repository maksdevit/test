<?php
namespace App\Services;

use Carbon\Carbon;
use DateTime;

class ScheduleService
{
    /**
     * @param $date DateTime
     * @return bool
     */
    public static function checkWorksDays($date)
    {
        $workingDays = explode(",", config('app.WorkingDays'));
        return in_array($date->dayOfWeek, $workingDays) && self::checkExceptions($date);
    }

    /**
     * @param $date
     * @return bool
     */
    public static function checkWorksTime($date)
    {
        $workSince = config('app.WorkingHoursSince');
        $workUntil = config('app.WorkingHoursUntil');
        return $date->toTimeString() >= $workSince && $date->toTimeString() <= $workUntil;
    }

    /**
     * @param $date
     * @return bool
     */
    public static function checkBreakTime($date)
    {
        $breakSince = config('app.BreakSince');
        $breakUntil = config('app.BreakUtil');
        return $date->toTimeString() >= $breakSince && $date->toTimeString() <= $breakUntil;
    }

    /**
     * @return string (next open day/time)
     */
    public static function nextWorkDate()
    {
        $date = Carbon::now()->addDay();
        $workSince = config('app.WorkingHoursSince');
        $workingDays = explode(",", config('app.WorkingDays'));

        for ($i = 1; ; $i++) {
            if (
                !in_array($date->dayOfWeek, $workingDays) ||
                !self::checkExceptions($date)
            ) {
                $date->addDays(1);
            } else {
                $date->hour = explode(':', $workSince)[0];
                $date->minute = explode(':', $workSince)[1];
                return $date->diffForHumans();
            }
        }
    }

    /**
     * @param $date
     * @return bool
     */
    public static function checkExceptions($date)
    {
        return !in_array($date->toDateString(), explode(',', config('app.WorkingDaysExceptions')));
    }
}
