<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WeekTemplate extends Model
{
    use HasFactory;
    protected $fillable = ['kelas_id','name','week_type'];

    public function kelas(){ return $this->belongsTo(Kelas::class); }
    public function days(){ return $this->hasMany(WeekTemplateDay::class)->orderBy('day_order'); }
}
