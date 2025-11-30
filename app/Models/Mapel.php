<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mapel extends Model
{
    use HasFactory;
    protected $fillable = ['name','code','teacher_id'];

    public function schedules(){ return $this->hasMany(Schedule::class); }
    public function teacher(){ return $this->belongsTo(Teacher::class); }
}
