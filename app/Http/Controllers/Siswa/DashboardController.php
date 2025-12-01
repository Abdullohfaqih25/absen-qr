<?php
namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;
use Carbon\Carbon;
use App\Models\Student;
use App\Models\Schedule;
use App\Models\WeekTemplate;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $studentId = Auth::user()->related_id;
        $totalPresent = Attendance::where('student_id', $studentId)->count();
        $last = Attendance::where('student_id', $studentId)->latest('absent_at')->first();
        $student = Student::with('kelas')->find($studentId);
        // Use English day name (e.g. Monday) to match seeded schedule/week template values
        $todayName = Carbon::now()->format('l');
        $todaySchedules = [];
        $weekSchedules = [];
        $currentWeekType = (Carbon::now()->weekOfYear % 2) ? 1 : 2;

        if ($student && $student->kelas_id) {
            // Prefer week templates if available for the student's class
            $weekTemplate = WeekTemplate::where('kelas_id', $student->kelas_id)
                ->where('week_type', $currentWeekType)
                ->with(['days.template.slots.mapel','days.template.slots.teacher'])
                ->first();

            if ($weekTemplate) {
                // Build schedule per day name (English names stored in templates)
                foreach ($weekTemplate->days as $day) {
                    $dayName = $day->day_name; // e.g., Monday
                    $slots = collect();
                    if ($day->template) {
                        foreach ($day->template->slots as $slot) {
                            $slots->push((object)[
                                'start_time' => $slot->start_time,
                                'end_time' => $slot->end_time,
                                'subject' => $slot->mapel?->name ?? null,
                                'teacher' => $slot->teacher?->name ?? null,
                                'topic' => $slot->topic ?? null
                            ]);
                        }
                    }
                    $weekSchedules[$dayName] = $slots;
                }

                // set today's schedules from template if available
                $todaySchedules = $weekSchedules[Carbon::now()->format('l')] ?? collect();

                // fetch today's teacher availabilities for involved teachers
                $teacherIds = collect($todaySchedules)->pluck('teacher')->filter()->unique();
                $availMap = [];
                if($teacherIds->count()){
                    $rows = \App\Models\TeacherAvailability::whereIn('teacher_id',$teacherIds->toArray())->where('date', Carbon::today()->toDateString())->get();
                    foreach($rows as $r) $availMap[$r->teacher_id] = $r->is_absent;
                }
                // attach availability flag
                $todaySchedules = collect($todaySchedules)->map(function($s) use ($availMap){
                    $teacherName = $s->teacher ?? null;
                    $teacherId = null;
                    if(isset($s->teacher) && is_object($s->teacher) && isset($s->teacher->id)){
                        $teacherId = $s->teacher->id;
                        $teacherName = $s->teacher->name;
                    }
                    if(isset($s->teacher_id)) $teacherId = $s->teacher_id;
                    $isAbsent = $teacherId ? ($availMap[$teacherId] ?? false) : false;
                    return (object) array_merge((array)$s, ['teacher_name'=>$isAbsent ? null : $teacherName, 'teacher_is_absent'=>$isAbsent]);
                });
            } else {
                // Fallback to schedules table
                $todaySchedules = Schedule::with(['teacher','mapel'])
                    ->where('kelas_id', $student->kelas_id)
                    ->whereRaw('LOWER(day) = ?', [strtolower($todayName)])
                    ->orderBy('start_time')
                    ->get();

                // get teacher availabilities for today
                $teacherIds = $todaySchedules->pluck('teacher_id')->filter()->unique()->toArray();
                $rows = \App\Models\TeacherAvailability::whereIn('teacher_id',$teacherIds)->where('date', Carbon::today()->toDateString())->get();
                $availMap = [];
                foreach($rows as $r) $availMap[$r->teacher_id] = $r->is_absent;
                // attach flags
                $todaySchedules = $todaySchedules->map(function($s) use ($availMap){
                    $isAbsent = $s->teacher_id ? ($availMap[$s->teacher_id] ?? false) : false;
                    $s->teacher_name = $isAbsent ? null : ($s->teacher?->name ?? null);
                    $s->teacher_is_absent = $isAbsent;
                    return $s;
                });

                // build weekSchedules from schedules table grouped by day
                $all = Schedule::where('kelas_id', $student->kelas_id)
                    ->where('week_type', $currentWeekType)
                    ->orderBy('day')->orderBy('start_time')->get()
                    ->groupBy(function($s){ return $s->day; });
                foreach($all as $dayName => $group) {
                    $weekSchedules[$dayName] = $group->map(function($s){
                        return (object)[
                            'start_time' => $s->start_time,
                            'end_time' => $s->end_time,
                            'subject' => $s->subject,
                            'teacher' => $s->teacher?->name ?? null,
                            'topic' => $s->topic ?? null
                        ];
                    });
                }
            }
        }

        return view('siswa.dashboard.index', compact('totalPresent', 'last', 'todaySchedules', 'student', 'weekSchedules'));
    }
}
