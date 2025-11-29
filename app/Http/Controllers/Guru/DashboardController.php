<?php
namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\QrToken;
use App\Models\Attendance;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $teacherId = Auth::user()->related_id;
        $today = Carbon::today()->toDateString();
        $token = QrToken::where('date', $today)->where('teacher_id', $teacherId)->first();
        $attCount = 0;
        if ($token) {
            $attCount = Attendance::whereDate('absent_at', Carbon::today())->where('token', $token->token)->count();
        }
        return view('guru.dashboard.index', compact('token', 'attCount'));
    }
}
