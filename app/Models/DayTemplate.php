<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DayTemplate extends Model
{
    use HasFactory;
    protected $fillable = ['name','description'];

    public function slots(){ return $this->hasMany(DaySlot::class)->orderBy('slot_order'); }
}
