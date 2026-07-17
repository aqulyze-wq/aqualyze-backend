<?php

namespace App\Helpers;

use App\Models\ActivityLog;

class ActivityHelper
{
    public static function log($module, $activity)
    {
        ActivityLog::create([

            'user_id' => auth()->id(),

            'module' => $module,

            'activity' => $activity,

        ]);
    }
}