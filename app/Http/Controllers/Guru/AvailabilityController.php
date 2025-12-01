<?php
namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TeacherAvailability;
use Carbon\Carbon;

class AvailabilityController extends Controller
{
    public function toggle(Request $request)
    {
        $teacherId = Auth::user()->related_id;
        $today = Carbon::today()->toDateString();

        $avail = TeacherAvailability::firstOrNew(['teacher_id'=>$teacherId,'date'=>$today]);
        // toggle based on action param: 'absent' => mark absent true, otherwise mark present
        $action = $request->input('action');
        if($action === 'absent'){
            $avail->is_absent = true;
            $avail->note = $request->input('note');
        } else {
            $avail->is_absent = false;
            $avail->note = $request->input('note');
        }
        $avail->save();

        return back()->with('success','Status kehadiran diperbarui.');
    }
}
