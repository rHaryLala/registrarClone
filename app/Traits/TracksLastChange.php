<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

trait TracksLastChange
{
    public static function bootTracksLastChange()
    {
        static::saving(function (Model $model) {
            try {
                $user = Auth::user();
            } catch (\Throwable $e) {
                $user = null;
            }

            if ($user && method_exists($model, 'setAttribute')) {
                $model->setAttribute('last_change_user_id', $user->id);
            }
            $model->setAttribute('last_change_datetime', now());
        });
    }
}
