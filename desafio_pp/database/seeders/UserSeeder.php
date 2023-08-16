<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Sabino Machado',
            'email' => 'desafio@perfectpay.com.br',
            'password' => Hash::make('password'),
            'cpf'=> '349.978.670-20',
            'telefone' => '24992471465',
        ]);
    }
}
