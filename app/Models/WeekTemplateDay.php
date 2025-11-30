<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WeekTemplateDay extends Model
{
    use HasFactory;
    protected $table = 'week_template_days';
    protected $fillable = ['week_template_id','day_name','day_template_id','day_order'];

    public function template(){ return $this->belongsTo(DayTemplate::class,'day_template_id'); }
    public function weekTemplate(){ return $this->belongsTo(WeekTemplate::class,'week_template_id'); }
}
