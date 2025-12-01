<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(){
        Schema::create('teacher_availabilities', function(Blueprint $table){
            $table->id();
            $table->foreignId('teacher_id')->constrained('teachers')->cascadeOnDelete();
            $table->date('date');
            $table->boolean('is_absent')->default(false);
            $table->text('note')->nullable();
            $table->timestamps();
            $table->unique(['teacher_id','date']);
        });
    }
    public function down(){ Schema::dropIfExists('teacher_availabilities'); }
};
