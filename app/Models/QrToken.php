<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QrToken extends Model
{
    use HasFactory;
    protected $fillable = ['token','date','teacher_id'];
}
