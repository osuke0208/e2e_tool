<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $params = [
          'name' => 'root',
          'email' => 'root@example',
          'password' => bcrypt('password'),
        ];
        DB::table('users')->insert($params);
    }
}
