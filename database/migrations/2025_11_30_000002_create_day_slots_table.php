<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(){
        Schema::create('day_slots', function(Blueprint $table){
            $table->id();
            $table->foreignId('day_template_id')->constrained('day_templates')->cascadeOnDelete();
            $table->foreignId('mapel_id')->nullable()->constrained('mapels')->nullOnDelete();
            $table->foreignId('teacher_id')->nullable()->constrained('teachers')->nullOnDelete();
            $table->time('start_time');
            $table->time('end_time');
            $table->integer('slot_order')->default(1)->comment('Order of slot in the day');
            $table->string('topic')->nullable();
            $table->timestamps();
        });
    }
    public function down(){ Schema::dropIfExists('day_slots'); }
};
