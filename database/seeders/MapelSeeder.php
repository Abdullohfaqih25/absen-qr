<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mapel;

class MapelSeeder extends Seeder
{
    public function run()
    {
        $mapels = ['Matematika','Fisika','Kimia','Biologi','Bahasa Indonesia','Bahasa Inggris','Produktif TKJ','Produktif RPL','Sejarah'];
        foreach($mapels as $m){ Mapel::create(['name'=>$m]); }
    }
}
