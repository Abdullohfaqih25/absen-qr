<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Schedule extends Model
{
    use HasFactory;
    protected $fillable = ['kelas_id','teacher_id','subject','start_time','end_time','day'];

    public function kelas(){ return $this->belongsTo(Kelas::class); }
    public function teacher(){ return $this->belongsTo(Teacher::class); }
}
