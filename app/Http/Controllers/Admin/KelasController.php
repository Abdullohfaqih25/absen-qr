<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kelas;

class KelasController extends Controller{
    public function index(){ 
        // Use withCount to get accurate student counts efficiently
        $kelas = Kelas::withCount('students')->paginate(25); 
        return view('admin.kelas.index', compact('kelas')); 
    }
    
    public function create(){ 
        return view('admin.kelas.create'); 
    }
    
    public function store(Request $r){ 
        $v=$r->validate(['name'=>'required','room'=>'nullable','capacity'=>'nullable|integer|min:0']); 
        Kelas::create($v); 
        return redirect()->route('admin.kelas.index')->with('success','Kelas ditambahkan'); 
    }
    
    public function edit(Kelas $kela){ 
        return view('admin.kelas.edit', compact('kela')); 
    }
    
    public function update(Request $r, Kelas $kela){ 
        $v=$r->validate(['name'=>'required','room'=>'nullable','capacity'=>'nullable|integer|min:0']); 
        $kela->update($v); 
        return redirect()->route('admin.kelas.index')->with('success','Diupdate'); 
    }
    
    public function destroy(Kelas $kela){ 
        $kela->delete(); 
        return back()->with('success','Dihapus'); 
    }
}
