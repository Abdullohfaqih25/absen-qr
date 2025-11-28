<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['name','email','password','role','related_id'];
    protected $hidden = ['password','remember_token'];

    public function isAdmin(){ return $this->role === 'admin'; }
    public function isGuru(){ return $this->role === 'guru'; }
    public function isSiswa(){ return $this->role === 'siswa'; }

    public function student(){ return $this->hasOne(Student::class, 'id', 'related_id'); }
    public function teacher(){ return $this->hasOne(Teacher::class, 'id', 'related_id'); }
}
