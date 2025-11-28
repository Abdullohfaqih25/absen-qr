<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Kelas;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AttendancesExport;

class AttendanceController extends Controller{
    public function index(Request $r){
        $q = Attendance::with('student.kelas');
        if($r->filled('date')) $q->whereDate('absent_at',$r->date);
        if($r->filled('kelas')) $q->whereHas('student', function($qq) use($r){ $qq->where('kelas_id',$r->kelas); });
        if($r->filled('nis')) $q->whereHas('student', function($qq) use($r){ $qq->where('nis','like','%'.$r->nis.'%'); });
        $attendances = $q->orderBy('absent_at','desc')->paginate(25);
        $kelas = Kelas::all();
        return view('admin.attendance.index', compact('attendances','kelas'));
    }

    public function export(Request $r){
        return Excel::download(new AttendancesExport($r->all()), 'attendances.xlsx');
    }
}
