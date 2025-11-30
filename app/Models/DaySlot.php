<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DaySlot extends Model
{
    use HasFactory;
    protected $fillable = ['day_template_id','mapel_id','teacher_id','start_time','end_time','slot_order','topic'];

    public function template(){ return $this->belongsTo(DayTemplate::class,'day_template_id'); }
    public function mapel(){ return $this->belongsTo(Mapel::class); }
    public function teacher(){ return $this->belongsTo(Teacher::class); }
}
