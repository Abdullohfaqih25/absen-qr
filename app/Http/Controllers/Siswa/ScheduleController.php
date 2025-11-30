<?php
namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Schedule;

class ScheduleController extends Controller
{
    protected function currentWeekType(): int
    {
        $week = Carbon::now()->weekOfYear;
        return $week % 2 === 1 ? 1 : 2; // odd = minggu 1, even = minggu 2
    }

    public function index(Request $r)
    {
        $user = auth()->user();
        $student = $user && $user->role === 'siswa' ? $user->student : null;
        if (!$student) return redirect()->route('siswa.dashboard')->with('error','Akses ditolak');

        $weekType = $this->currentWeekType();
        $day = Carbon::now()->format('l'); // Monday, Tuesday ...

        $schedules = Schedule::with(['teacher','mapel'])
            ->where('kelas_id',$student->kelas_id)
            ->where('week_type',$weekType)
            ->where('day',$day)
            ->orderBy('start_time')
            ->get();

        // find current ongoing class
        $now = Carbon::now();
        $ongoing = Schedule::with(['teacher','mapel'])
            ->where('kelas_id',$student->kelas_id)
            ->where('week_type',$weekType)
            ->where('day',$day)
            ->whereTime('start_time','<=',$now->format('H:i:s'))
            ->whereTime('end_time','>=',$now->format('H:i:s'))
            ->first();

        return view('siswa.jadwal.index', compact('schedules','weekType','student','ongoing'));
    }
}
