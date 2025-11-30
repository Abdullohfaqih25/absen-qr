<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\QrToken;

class DatabaseSeeder extends Seeder
{
    public function run(){
        // Admin User
        User::create([
            'name'=>'Admin User',
            'email'=>'admin@sekolah.test',
            'password'=>bcrypt('password'),
            'role'=>'admin'
        ]);

        // Create Kelas
        $kelas1 = Kelas::create(['name'=>'X IPA 1', 'room' => '101']);
        $kelas2 = Kelas::create(['name'=>'X IPA 2', 'room' => '102']);
        $kelas3 = Kelas::create(['name'=>'X IPS 1', 'room' => '103']);

        // Create Students
        $students = Student::factory()->count(30)->create(['kelas_id'=>$kelas1->id]);
        foreach($students as $s){
            User::create([
                'name'=>$s->name,
                'email'=>strtolower($s->nis).'@student.absenqr.local',
                'password'=>bcrypt('password'),
                'role'=>'siswa',
                'related_id'=>$s->id
            ]);
        }

        // Students for Kelas 2
        $students2 = Student::factory()->count(25)->create(['kelas_id'=>$kelas2->id]);
        foreach($students2 as $s){
            User::create([
                'name'=>$s->name,
                'email'=>strtolower($s->nis).'@student.absenqr.local',
                'password'=>bcrypt('password'),
                'role'=>'siswa',
                'related_id'=>$s->id
            ]);
        }

        // Create Teachers
        $teachers = [
            ['name'=>'Budi Santoso', 'nip'=>'19801015 200801 1 001'],
            ['name'=>'Siti Nurhaliza', 'nip'=>'19851120 201101 2 005'],
            ['name'=>'Ahmad Hidayat', 'nip'=>'19900305 201412 1 008'],
        ];

        foreach($teachers as $data){
            $t = Teacher::create($data);
            $email = strtolower(str_replace(' ','',$t->name)) . '@guru.absenqr.local';
            User::create([
                'name'=>$t->name,
                'email'=>$email,
                'password'=>bcrypt('password'),
                'role'=>'guru',
                'related_id'=>$t->id
            ]);
        }

        // Create QR Tokens for today
        $teachers = Teacher::all();
        foreach($teachers as $t){
            QrToken::create([
                'token'=>bin2hex(random_bytes(8)),
                'date'=>now()->toDateString(),
                'teacher_id'=>$t->id
            ]);
        }

        // Mapel & schedules
        $this->call(\Database\Seeders\MapelSeeder::class);
        $this->call(\Database\Seeders\ScheduleSeeder::class);
    }
}

