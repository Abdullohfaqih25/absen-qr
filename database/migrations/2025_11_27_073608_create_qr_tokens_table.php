<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(){
        Schema::create('qr_tokens', function(Blueprint $table){
            $table->id();
            $table->string('token')->unique();
            $table->date('date');
            $table->foreignId('teacher_id')->nullable()->constrained('teachers')->nullOnDelete();
            $table->timestamps();
        });
    }
    public function down(){ Schema::dropIfExists('qr_tokens'); }
};
