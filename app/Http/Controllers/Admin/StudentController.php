<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\User;
use App\Models\Kelas;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\StudentsExport;

class StudentController extends Controller
{
    public function index(Request $r){
        $q = Student::with('kelas');
        if($r->filled('q')) $q->where('name','like','%'.$r->q.'%')->orWhere('nis','like','%'.$r->q.'%');
        $students = $q->paginate(25);
        return view('admin.students.index', compact('students'));
    }

    public function create(){ 
        $kelas = Kelas::all();
        return view('admin.students.create', compact('kelas')); 
    }

    public function store(Request $request){
        $v = $request->validate([ 'nis'=>'required|unique:students,nis', 'name'=>'required', 'kelas_id'=>'required|exists:kelas,id' ]);
        $student = Student::create($v);
        $email = strtolower($student->nis) . '@student.absenqr.local';
        User::create(['name'=>$student->name,'email'=>$email,'password'=>bcrypt('password'),'role'=>'siswa','related_id'=>$student->id]);
        return redirect()->route('admin.students.index')->with('success','Siswa ditambahkan');
    }

    public function edit(Student $student){ 
        $kelas = Kelas::all();
        return view('admin.students.edit', compact('student','kelas')); 
    }

    public function update(Request $request, Student $student){
        $v = $request->validate([ 'name'=>'required', 'nis'=>'required|unique:students,nis,'.$student->id, 'kelas_id'=>'required|exists:kelas,id']);
        $student->update($v);
        return redirect()->route('admin.students.index')->with('success','Diupdate');
    }

    public function destroy(Student $student){
        User::where('related_id',$student->id)->where('role','siswa')->delete();
        $student->delete();
        return back()->with('success','Dihapus');
    }

    public function export(){
        return Excel::download(new StudentsExport, 'students.xlsx');
    }
}
