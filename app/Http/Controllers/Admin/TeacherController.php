<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\User;

class TeacherController extends Controller{
    public function index(){ 
        $teachers = Teacher::paginate(25); 
        return view('admin.teachers.index', compact('teachers')); 
    }
    
    public function create(){ 
        return view('admin.teachers.create'); 
    }
    
    public function store(Request $r){ 
        $v=$r->validate([
            'name'=>'required',
            'email'=>'nullable|email|unique:users,email',
            'nip'=>'nullable|unique:teachers,nip',
            'password'=>'nullable|string|min:6'
        ]);

        $t=Teacher::create(['name'=>$v['name'],'email'=>$v['email'] ?? null,'nip'=>$v['nip'] ?? null]); 
        $email = $v['email'] ?? strtolower(str_replace(' ','',$t->name)) . '@guru.absenqr.local';
        $password = isset($v['password']) && $v['password'] ? bcrypt($v['password']) : bcrypt('password');
        User::create(['name'=>$t->name,'email'=>$email,'password'=>$password,'role'=>'guru','related_id'=>$t->id]); 
        return redirect()->route('admin.teachers.index')->with('success','Guru ditambahkan'); 
    }
    
    public function edit(Teacher $teacher){ 
        return view('admin.teachers.edit', compact('teacher')); 
    }
    
    public function update(Request $r, Teacher $teacher){ 
        $v=$r->validate(['name'=>'required', 'email'=>'nullable|email|unique:users,email,'.$teacher->user->id.',id', 'nip'=>'nullable|unique:teachers,nip,'.$teacher->id]); 
        $teacher->update($v); 
        return redirect()->route('admin.teachers.index')->with('success','Diupdate'); 
    }
    
    public function destroy(Teacher $teacher){ 
        User::where('related_id',$teacher->id)->where('role','guru')->delete(); 
        $teacher->delete(); 
        return back()->with('success','Dihapus'); 
    }
}

