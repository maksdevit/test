<?php

namespace App\Http\Controllers;

use App\Services\ScheduleService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WorkingScheduleController extends Controller
{

    /**
     * Get the shop status (open/closed), nearest date for open.
     *
     * @return \Illuminate\Http\Response
     */
    public function shopStatus(Request $request)
    {
        $date = Carbon::now();

        if (ScheduleService::checkBreakTime($date)) {
            $breakUntil = config('app.BreakUtil');
            return response([
                'message' => __('messages.break', [
                    'time' => $breakUntil
                ])
            ]);
        }

        if (ScheduleService::checkWorksTime($date) && ScheduleService::checkWorksDays($date)) {
            return response([
                'message' => __('messages.open')
            ]);
        }

        return response([
            'message' => __('messages.closed', [
                'time' => ScheduleService::nextWorkDate()
            ])
        ]);

    }

    /**
     * Get the shop status for some date (open/closed), nearest date for open.
     *
     * @return \Illuminate\Http\Response
     */
    public function shopWorkingDates(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date_format:Y-m-d',
        ]);

        $date = new Carbon($validated['date']);

        if (ScheduleService::checkWorksDays($date)) {
            return response([
                'message' => __('messages.open_day')
            ]);
        }

        return response([
            'message' => __('messages.closed_day', [
                'time' => ScheduleService::nextWorkDate()
            ])
        ]);

    }

}
