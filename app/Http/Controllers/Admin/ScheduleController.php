<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\Kelas;
use App\Models\Teacher;
use App\Models\Mapel;

class ScheduleController extends Controller
{
    public function index(Request $r)
    {
        $q = Schedule::with(['kelas','teacher','mapel']);
        if ($r->filled('kelas')) $q->where('kelas_id',$r->kelas);
        if ($r->filled('week_type')) $q->where('week_type',$r->week_type);
        $schedules = $q->orderBy('day')->orderBy('start_time')->paginate(30);
        $kelas = Kelas::all();
        return view('admin.schedules.index', compact('schedules','kelas'));
    }

    public function create()
    {
        $kelas = Kelas::all();
        $teachers = Teacher::all();
        $mapels = Mapel::all();
        return view('admin.schedules.create', compact('kelas','teachers','mapels'));
    }

    public function store(Request $r)
    {
        $v = $r->validate([
            'kelas_id'=>'required|exists:kelas,id',
            'teacher_id'=>'required|exists:teachers,id',
            'mapel_id'=>'nullable|exists:mapels,id',
            'subject'=>'nullable|string',
            'day'=>'required|string',
            'start_time'=>'required',
            'end_time'=>'required',
            'week_type'=>'required|in:1,2',
            'room'=>'nullable|string',
            'topic'=>'nullable|string'
        ]);

        // If mapel is selected but subject not provided, use mapel name as subject
        if (empty($v['subject']) && !empty($v['mapel_id'])) {
            $m = Mapel::find($v['mapel_id']);
            if ($m) { $v['subject'] = $m->name; }
        }

        Schedule::create($v);
        return redirect()->route('admin.schedules.index')->with('success','Jadwal ditambahkan');
    }

    public function edit(Schedule $schedule)
    {
        $kelas = Kelas::all();
        $teachers = Teacher::all();
        $mapels = Mapel::all();
        return view('admin.schedules.edit', compact('schedule','kelas','teachers','mapels'));
    }

    public function update(Request $r, Schedule $schedule)
    {
        $v = $r->validate([
            'kelas_id'=>'required|exists:kelas,id',
            'teacher_id'=>'required|exists:teachers,id',
            'mapel_id'=>'nullable|exists:mapels,id',
            'subject'=>'nullable|string',
            'day'=>'required|string',
            'start_time'=>'required',
            'end_time'=>'required',
            'week_type'=>'required|in:1,2',
            'room'=>'nullable|string',
            'topic'=>'nullable|string'
        ]);
        // If mapel is selected but subject not provided, use mapel name as subject
        if (empty($v['subject']) && !empty($v['mapel_id'])) {
            $m = Mapel::find($v['mapel_id']);
            if ($m) { $v['subject'] = $m->name; }
        }

        $schedule->update($v);
        return redirect()->route('admin.schedules.index')->with('success','Diupdate');
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return back()->with('success','Dihapus');
    }
}

