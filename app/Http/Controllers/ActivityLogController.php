<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\User;

class ActivityLogController extends Controller
{
    public function index()
    {
        $logs = ActivityLog::with('user')
                    ->latest()
                    ->get();

        $totalActivity = ActivityLog::count();

        $userActive = User::count();

        $deviceEvent = ActivityLog::where('module','Device')->count();

        $warning = ActivityLog::where('activity','LIKE','%offline%')
                    ->orWhere('activity','LIKE','%warning%')
                    ->count();

        return view('activity.index', compact(

            'logs',

            'totalActivity',

            'userActive',

            'deviceEvent',

            'warning'

        ));
    }
}