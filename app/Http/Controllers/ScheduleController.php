<?php


namespace App\Http\Controllers;


use App\Registration;
use Illuminate\Support\Facades\DB;

class ScheduleController extends Controller
{
    public function index()
    {
        return Registration::select([
            DB::raw('activity_code'),
            DB::raw('course_name as title'),
            DB::raw('start_date as start'),
            DB::raw('end_date as end')
        ])->whereBetween('start_date', [request('from'), request('to')])
            ->distinct()
            ->get()->transform(function($item) {
                return array_merge($item->toArray(), [
                    'id' => $item->activity_code
                ]);
            });
    }
}
