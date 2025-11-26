<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $query = ActivityLog::query();

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('table_name')) {
            $query->where('table_name', 'like', '%' . $request->table_name . '%');
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $query->select('id', 'user_id', 'role', 'action', 'table_name', 'record_id', 'old_data', 'new_data', 'created_at');

        $logs = $query->orderBy('created_at', 'desc')
                      ->paginate(25)
                      ->appends($request->query());
                      

        return view('activity_logs.index', compact('logs'));
    }
}
