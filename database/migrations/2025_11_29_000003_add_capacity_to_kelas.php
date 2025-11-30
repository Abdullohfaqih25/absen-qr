<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(){
        Schema::table('kelas', function(Blueprint $table){
            if (!Schema::hasColumn('kelas','capacity')) {
                $table->integer('capacity')->nullable()->after('room');
            }
        });
    }

    public function down(){
        Schema::table('kelas', function(Blueprint $table){
            if (Schema::hasColumn('kelas','capacity')) $table->dropColumn('capacity');
        });
    }
};
