<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(){
        Schema::create('attendances', function(Blueprint $table){
            $table->id();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->dateTime('absent_at');
            $table->enum('status', ['Hadir','Terlambat'])->default('Hadir');
            $table->string('device')->nullable();
            $table->string('ip')->nullable();
            $table->decimal('lat', 10, 7)->nullable();
            $table->decimal('lng', 10, 7)->nullable();
            $table->string('token')->nullable();
            $table->timestamps();
        });
    }
    public function down(){ Schema::dropIfExists('attendances'); }
};
