<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mapel;
use App\Models\Teacher;

class MapelController extends Controller
{
    public function index()
    {
        $mapels = Mapel::with('teacher')->paginate(25);
        return view('admin.mapels.index', compact('mapels'));
    }

    public function create()
    {
        $teachers = Teacher::all();
        return view('admin.mapels.create', compact('teachers'));
    }

    public function store(Request $r)
    {
        $v = $r->validate([ 'name'=>'required', 'code'=>'nullable', 'teacher_id'=>'nullable|exists:teachers,id' ]);
        Mapel::create($v);
        return redirect()->route('admin.mapels.index')->with('success','Mapel ditambahkan');
    }

    public function edit(Mapel $mapel)
    {
        $teachers = Teacher::all();
        return view('admin.mapels.edit', compact('mapel','teachers'));
    }

    public function update(Request $r, Mapel $mapel)
    {
        $v = $r->validate([ 'name'=>'required', 'code'=>'nullable', 'teacher_id'=>'nullable|exists:teachers,id' ]);
        $mapel->update($v);
        return redirect()->route('admin.mapels.index')->with('success','Diupdate');
    }

    public function destroy(Mapel $mapel)
    {
        $mapel->delete();
        return back()->with('success','Dihapus');
    }
}
