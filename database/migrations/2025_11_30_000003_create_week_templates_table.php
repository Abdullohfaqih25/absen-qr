<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(){
        Schema::create('week_templates', function(Blueprint $table){
            $table->id();
            $table->foreignId('kelas_id')->nullable()->constrained('kelas')->nullOnDelete();
            $table->string('name');
            $table->tinyInteger('week_type')->default(1)->comment('1 = minggu ke-1, 2 = minggu ke-2');
            $table->timestamps();
        });
    }
    public function down(){ Schema::dropIfExists('week_templates'); }
};
