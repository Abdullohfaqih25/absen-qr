<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(){
        $today = Carbon::today();
        $totalHadir = Attendance::whereDate('absent_at', $today)->count();
        $terlambat = Attendance::whereDate('absent_at', $today)->where('status','Terlambat')->count();
        $persenTerlambat = $totalHadir ? round(($terlambat / $totalHadir) * 100,2) : 0;

        $week = [];
        for($i=6;$i>=0;$i--){
            $d = Carbon::today()->subDays($i)->toDateString();
            $count = Attendance::whereDate('absent_at',$d)->count();
            $week[] = ['date'=>$d,'count'=>$count];
        }

        return view('admin.dashboard.index', compact('totalHadir','terlambat','persenTerlambat','week'));
    }
}
