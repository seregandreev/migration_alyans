<?php
namespace App\Http\Helpers;

use App\Models\Alarm;
use Illuminate\Support\Facades\Auth;

class UserHelper {
    /*
     * Список непрочитанных оповещений пользователя
     */
    public static function unreading_alarms()
    {
        if(Auth::user()->role == 'Работник лаборатории' || Auth::user()->role == 'Администратор')
        {
            $alarms = Alarm::where('is_reading', 0)
                ->count();
        } else {
            $alarms = Alarm::where('user_id', Auth::user()->company_id)
                ->where('is_reading', 0)
                ->count();
        }


        return $alarms;
    }

}