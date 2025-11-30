<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(){
        Schema::create('week_template_days', function(Blueprint $table){
            $table->id();
            $table->foreignId('week_template_id')->constrained('week_templates')->cascadeOnDelete();
            $table->string('day_name'); // e.g., Monday, Tuesday
            $table->foreignId('day_template_id')->nullable()->constrained('day_templates')->nullOnDelete();
            $table->integer('day_order')->default(0);
            $table->timestamps();
        });
    }
    public function down(){ Schema::dropIfExists('week_template_days'); }
};
