<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        User::factory()->create([
            'nombre' => 'Alec',
            'apellido' => 'Thompson',
            'correo' => 'admin@corporateui.com',
            'password' => Hash::make('secret'),
        ]); 

        DB::table('expedientes')->insert([
            'id_paciente' => 1,
            'fecha_reg' => now(),
            'fecha_actu' => now(),
            'seguimiento' => 'Le duele la panza :('
        ]);

        DB::table('pacientes')->insert([
            'nombre' => "Juanito",
            'edad' => 23,
            'sexo' => 'H',
            'telefono' => '+528342764567',
            'id_exp' => 1
        ]);
    }
}
