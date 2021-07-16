<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //create dummy records
        User::truncate();

        $users =  [
            [
              'email' => 'sarah@gmail.com',
              'name' => 'Sarah',
              'surname' => 'Pam',
              'Age' => '45',
              'gender' => 'female',
              'cadre' => 'Doctor',
              'department' => 'Medicine',
              'role' => 'healthworker',
              'password' => Hash::make('12345'),
            ],
            [
              'email' => 'idris@gmail.com',
              'name' => 'Idris',
              'surname' => 'Abu',
              'Age' => '37',
              'gender' => 'male',
              'cadre' => 'Doctor',
              'department' => 'Medicine',
              'role' => 'healthworker',
              'password' => Hash::make('12345'),
              ],
              [
              'email' => 'wale@gmail.com',
              'name' => 'Wale',
              'surname' => 'Oni',
              'Age' => '37',
              'gender' => 'male',
              'cadre' => 'Doctor',
              'department' => 'Medicine',
              'role' => 'healthworker',
              'password' => Hash::make('12345'),
              ],
              [
              'email' => 'rachael@gmail.com',
              'name' => 'rachael',
              'surname' => 'Inmo',
              'Age' => '29',
              'gender' => 'female',
              'cadre' => 'Doctor',
              'department' => 'Medicine',
              'role' => 'healthworker',
              'password' => Hash::make('12345'),
              ]

            ];

           User::insert($users);

      
          
    }
}


