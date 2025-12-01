<?php
namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\QrToken;
use App\Models\Attendance;
use App\Models\Schedule;
use App\Models\WeekTemplate;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $teacherId = Auth::user()->related_id;
        $today = Carbon::today()->toDateString();
        $todayName = Carbon::now()->format('l');
        $token = QrToken::where('date', $today)->where('teacher_id', $teacherId)->first();
        $attCount = 0;
        if ($token) {
            $attCount = Attendance::whereDate('absent_at', Carbon::today())->where('token', $token->token)->count();
        }
        // Collect schedules for today from week templates (preferred) and fallback to schedules table
        $currentWeekType = (Carbon::now()->weekOfYear % 2) ? 1 : 2;
        $templateSlots = collect();
        $weekTemplates = WeekTemplate::with(['kelas','days.template.slots.mapel','days.template.slots.teacher'])
            ->where('week_type', $currentWeekType)
            ->get();
        foreach($weekTemplates as $wt){
            foreach($wt->days as $wd){
                if(strtolower($wd->day_name) !== strtolower($todayName)) continue;
                if(!$wd->template) continue;
                foreach($wd->template->slots as $slot){
                    if($slot->teacher_id != $teacherId) continue;
                    $templateSlots->push((object)[
                        'start_time' => $slot->start_time,
                        'end_time' => $slot->end_time,
                        'mapel' => $slot->mapel?->name ?? null,
                        'kelas' => $wt->kelas?->name ?? null,
                        'teacher_id' => $slot->teacher_id
                    ]);
                }
            }
        }

        $tableSchedules = Schedule::with(['kelas','mapel'])
            ->where('teacher_id', $teacherId)
            ->whereRaw('LOWER(day) = ?', [strtolower($todayName)])
            ->orderBy('start_time')
            ->get()
            ->map(function($s){
                return (object)[
                    'start_time' => $s->start_time,
                    'end_time' => $s->end_time,
                    'mapel' => $s->mapel?->name ?? $s->subject ?? null,
                    'kelas' => $s->kelas?->name ?? null,
                    'teacher_id' => $s->teacher_id
                ];
            });

        // Merge template slots and table schedules then sort by start_time
        $todaySchedulesTeacher = $templateSlots->merge($tableSchedules)->sortBy('start_time')->values();

        return view('guru.dashboard.index', compact('token', 'attCount', 'todaySchedulesTeacher'));
    }
}
