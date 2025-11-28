<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Teacher extends Model
{
    use HasFactory;
    protected $fillable = ['nip','name','email'];
    public function user(){ return $this->hasOne(User::class, 'related_id')->where('role','guru'); }
}
