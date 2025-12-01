<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TeacherAvailability extends Model
{
    use HasFactory;
    protected $fillable = ['teacher_id','date','is_absent','note'];

    public function teacher(){ return $this->belongsTo(Teacher::class); }
}
