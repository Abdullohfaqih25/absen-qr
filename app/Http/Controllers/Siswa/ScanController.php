<?php
namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Student;
use App\Models\QrToken;
use Carbon\Carbon;

class ScanController extends Controller
{
    public function scanPage(){ return view('siswa.scan.index'); }

    public function store(Request $request){
        $request->validate(['token'=>'required','nis'=>'required']);
        $student = Student::where('nis',$request->nis)->first();
        if(!$student) return response()->json(['error'=>'NIS tidak ditemukan'],422);

        $q = QrToken::where('date', Carbon::today()->toDateString())->where('token', $request->token)->first();
        if(!$q) return response()->json(['error'=>'QR Tidak Valid'], 422);

        $exists = Attendance::whereDate('absent_at', Carbon::today())->where('student_id', $student->id)->exists();
        if($exists) return response()->json(['message'=>'Sudah absen hari ini'], 200);

        $time = Carbon::now();
        $deadline = Carbon::createFromTime(7,15,0);
        $status = $time->gt($deadline) ? 'Terlambat' : 'Hadir';

        $att = Attendance::create([
            'student_id'=>$student->id,
            'absent_at'=>$time,
            'status'=>$status,
            'device'=>$request->device ?? $request->header('User-Agent'),
            'ip'=>$request->ip(),
            'lat'=>$request->lat,
            'lng'=>$request->lng,
            'token'=>$request->token
        ]);

        return response()->json(['success'=>true, 'attendance'=>$att], 201);
    }
}
