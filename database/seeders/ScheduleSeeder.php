<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Schedule;
use App\Models\Kelas;
use App\Models\Teacher;
use App\Models\Mapel;

class ScheduleSeeder extends Seeder
{
    public function run()
    {
        $kelas = Kelas::all();
        $teachers = Teacher::all();
        $mapels = Mapel::all();

        if ($kelas->isEmpty() || $teachers->isEmpty() || $mapels->isEmpty()) return;

        // Create simple schedules: Monday-Friday, two periods per day, alternate week_type
        foreach($kelas as $k){
            foreach(['Monday','Tuesday','Wednesday','Thursday','Friday'] as $day){
                // period 1
                Schedule::create([
                    'kelas_id'=>$k->id,
                    'teacher_id'=>$teachers->random()->id,
                    'mapel_id'=>$mapels->random()->id,
                    'subject'=>null,
                    'start_time'=>'08:00:00',
                    'end_time'=>'09:30:00',
                    'day'=>$day,
                    'week_type'=>1,
                    'topic'=>null
                ]);
                // period 2
                Schedule::create([
                    'kelas_id'=>$k->id,
                    'teacher_id'=>$teachers->random()->id,
                    'mapel_id'=>$mapels->random()->id,
                    'subject'=>null,
                    'start_time'=>'09:45:00',
                    'end_time'=>'11:15:00',
                    'day'=>$day,
                    'week_type'=>2,
                    'topic'=>null
                ]);
            }
        }
    }
}
