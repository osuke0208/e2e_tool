<?php

use Illuminate\Database\Seeder;

class OrganisationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $data[] = [
          'name' => 'sample',
          'description' => 'my first organisation',
          'created_at' => now(),
          'updated_at' => now()
        ];
        DB::table('organisation')->insert($data);
    }
}
