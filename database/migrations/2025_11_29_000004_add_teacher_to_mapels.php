<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(){
        Schema::table('mapels', function(Blueprint $table){
            if (!Schema::hasColumn('mapels','teacher_id')) {
                $table->foreignId('teacher_id')->nullable()->after('code')->constrained('teachers')->nullOnDelete();
            }
        });
    }

    public function down(){
        Schema::table('mapels', function(Blueprint $table){
            if (Schema::hasColumn('mapels','teacher_id')) { $table->dropForeign(['teacher_id']); $table->dropColumn('teacher_id'); }
        });
    }
};
