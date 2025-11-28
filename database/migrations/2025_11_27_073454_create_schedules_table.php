<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(){
        Schema::create('schedules', function(Blueprint $table){
            $table->id();
            $table->foreignId('kelas_id')->constrained('kelas')->cascadeOnDelete();
            $table->foreignId('teacher_id')->constrained('teachers')->cascadeOnDelete();
            $table->string('subject');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('day');
            $table->timestamps();
        });
    }
    public function down(){ Schema::dropIfExists('schedules'); }
};
