<?php

namespace App\Http\Controllers;

use App\Models\Alarm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlarmController extends Controller
{
    /*
     * Список оповещений
     */
    public function index()
    {
        if(Auth::user()->role == 'Работник лаборатории' || Auth::user()->role == 'Администратор')
        {
            $alarms = Alarm::where('is_reading', 0)
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $alarms = Alarm::where('user_id', Auth::user()->company_id)
                ->where('is_reading', 0)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('alarms.index', [
            'alarms' => $alarms,
        ]);
    }


    /*
     * Подгрузка оповещения
     */
    public function show(Request $request)
    {
        $alarm_id = (int) $request->alarm_id;
        if(Auth::user()->role == 'Работник лаборатории' || Auth::user()->role == 'Администратор'){
            $alarm = Alarm::where('id', $alarm_id)
                ->first();
        } else {
            $alarm = Alarm::where('id', $alarm_id)
                ->where('user_id', Auth::user()->company_id)
                ->first();
        }

        if(empty($alarm))
            abort(403);

        // меняем статус на прочитано
        Alarm::findOrFail($alarm_id)
            ->update([
                'is_reading' => 1,
            ]);

        return $alarm;
    }
    
    // отметить всех прочитанными
    function changeReading()
    {
        Alarm::where('is_reading', 0)
            ->update([
                'is_reading' => 1,
            ]);
            
        return back()->with('success', 'Все оповещения отмечены прочитанными');
    }
}
