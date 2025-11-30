<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(){
        Schema::table('schedules', function(Blueprint $table){
            if (!Schema::hasColumn('schedules','mapel_id')) {
                $table->foreignId('mapel_id')->nullable()->after('teacher_id')->constrained('mapels')->nullOnDelete();
            }
            if (!Schema::hasColumn('schedules','week_type')) {
                $table->tinyInteger('week_type')->default(1)->after('day')->comment('1 = minggu ke-1 (kejuruan), 2 = minggu ke-2 (umum)');
            }
            if (!Schema::hasColumn('schedules','room')) {
                $table->string('room')->nullable()->after('end_time');
            }
            if (!Schema::hasColumn('schedules','topic')) {
                $table->text('topic')->nullable()->after('room');
            }
        });
    }

    public function down(){
        Schema::table('schedules', function(Blueprint $table){
            if (Schema::hasColumn('schedules','mapel_id')) { $table->dropForeign(['mapel_id']); $table->dropColumn('mapel_id'); }
            if (Schema::hasColumn('schedules','week_type')) { $table->dropColumn('week_type'); }
            if (Schema::hasColumn('schedules','room')) { $table->dropColumn('room'); }
            if (Schema::hasColumn('schedules','topic')) { $table->dropColumn('topic'); }
        });
    }
};
