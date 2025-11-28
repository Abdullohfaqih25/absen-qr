<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\Kelas;
use App\Models\Teacher;

class ScheduleController extends Controller{
    public function index(){ $schedules = Schedule::with('kelas','teacher')->paginate(25); return view('admin.schedules.index', compact('schedules')); }
    public function create(){ $kelas = Kelas::all(); $teachers = Teacher::all(); return view('admin.schedules.create', compact('kelas','teachers')); }
    public function store(Request $r){ $v=$r->validate(['kelas_id'=>'required','teacher_id'=>'required','subject'=>'required','start_time'=>'required','end_time'=>'required','day'=>'required']); Schedule::create($v); return redirect()->route('admin.schedules.index')->with('success','Jadwal ditambahkan'); }
    public function edit(Schedule $schedule){ $kelas = Kelas::all(); $teachers = Teacher::all(); return view('admin.schedules.edit', compact('schedule','kelas','teachers')); }
    public function update(Request $r, Schedule $schedule){ $v=$r->validate(['kelas_id'=>'required','teacher_id'=>'required','subject'=>'required','start_time'=>'required','end_time'=>'required','day'=>'required']); $schedule->update($v); return redirect()->route('admin.schedules.index')->with('success','Diupdate'); }
    public function destroy(Schedule $schedule){ $schedule->delete(); return back()->with('success','Dihapus'); }
}
