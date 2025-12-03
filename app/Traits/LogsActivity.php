<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait LogsActivity
{
    public static function bootLogsActivity()
    {
        static::created(function ($model) {
            self::logEvent('create', $model, null, $model->toArray());
        });

        static::updated(function ($model) {
            self::logEvent(
                'update',
                $model,
                $model->getOriginal(),
                $model->getChanges()
            );
        });

        static::deleted(function ($model) {
            self::logEvent(
                'delete',
                $model,
                $model->toArray(),
                null
            );
        });
    }

    protected static function logEvent($action, $model, $oldData, $newData)
    {
        $user = Auth::user();

        if (!$user) {
            // Skip logging if no authenticated user
            return;
        }

        \App\Models\ActivityLog::create([
            'user_id'    => $user->id,
            'role'       => $user->role ?? 'guest',
            'action'     => $action,
            'table_name' => $model->getTable(),
            'record_id'  => $model->id,
            'old_data'   => $oldData ? json_encode($oldData) : null,
            'new_data'   => $newData ? json_encode($newData) : null,
            'ip_address' => request()->ip() ?? '127.0.0.1',
        ]);
    }

}

?>