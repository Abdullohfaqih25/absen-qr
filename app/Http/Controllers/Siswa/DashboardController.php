<?php
namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;
use Carbon\Carbon;
use App\Models\Student;
use App\Models\Schedule;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $studentId = Auth::user()->related_id;
        $totalPresent = Attendance::where('student_id', $studentId)->count();
        $last = Attendance::where('student_id', $studentId)->latest('absent_at')->first();
        $student = Student::with('kelas')->find($studentId);
        $todayIndex = Carbon::now()->dayOfWeek; // 0 (Sun) - 6 (Sat)
        $days = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
        $todayName = $days[$todayIndex];
        $todaySchedules = [];
        if ($student && $student->kelas_id) {
            $todaySchedules = Schedule::where('kelas_id', $student->kelas_id)
                ->whereRaw('LOWER(day) = ?', [strtolower($todayName)])
                ->orderBy('start_time')
                ->get();
        }

        return view('siswa.dashboard.index', compact('totalPresent', 'last', 'todaySchedules', 'student'));
    }
}
