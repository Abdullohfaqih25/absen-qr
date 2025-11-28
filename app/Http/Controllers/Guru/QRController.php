<?php
namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\QrToken;
use Carbon\Carbon;
use App\Models\Attendance;

class QRController extends Controller
{
    public function showToday(){
        $today = Carbon::today()->toDateString();
        $teacherId = auth()->user()->related_id;
        $token = QrToken::firstOrCreate(['date'=>$today,'teacher_id'=>$teacherId], ['token'=>bin2hex(random_bytes(8))]);
        return view('guru.qr.show', ['token'=>$token]);
    }

    public function regenerate(Request $r){
        $today = Carbon::today()->toDateString();
        $teacherId = auth()->user()->related_id;
        $new = bin2hex(random_bytes(8));
        QrToken::updateOrCreate(['date'=>$today,'teacher_id'=>$teacherId], ['token'=>$new]);
        return redirect()->route('guru.qr.show')->with('success','QR diregenerate');
    }

    public function realtimeList(){
        $attendances = Attendance::whereDate('absent_at', Carbon::today())->with('student.kelas')->get();
        return view('guru.qr.realtime', compact('attendances'));
    }
}
