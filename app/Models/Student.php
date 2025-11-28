<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;
    protected $fillable = ['nis','name','email','kelas_id','photo'];

    public function user(){ return $this->hasOne(User::class, 'related_id')->where('role','siswa'); }
    public function kelas(){ return $this->belongsTo(Kelas::class); }
}
