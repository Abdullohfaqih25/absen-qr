<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(){
        Schema::create('students', function(Blueprint $table){
            $table->id();
            $table->string('nis')->unique();
            $table->string('name');
            $table->string('email')->nullable();
            $table->foreignId('kelas_id')->nullable()->constrained('kelas')->nullOnDelete();
            $table->string('photo')->nullable();
            $table->timestamps();
        });
    }
    public function down(){ Schema::dropIfExists('students'); }
};
