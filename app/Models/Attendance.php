<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attendance extends Model
{
    use HasFactory;
    protected $fillable = ['student_id','teacher_id','absent_at','status','device','ip','lat','lng','token'];
    protected $dates = ['absent_at'];
    public function student(){ return $this->belongsTo(Student::class); }
    public function teacher(){ return $this->belongsTo(Teacher::class); }
}
