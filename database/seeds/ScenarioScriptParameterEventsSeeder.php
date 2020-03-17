<?php

use Illuminate\Database\Seeder;

class ScenarioScriptParameterEventsSeeder extends Seeder
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
            'click',
            'clickWithAlert',
            'slack',
            'inputAdd',
            'input',
            'inputRandom',
            'save_param',
            'output',
            'outputValue',
            'verify',
            'select',
            'selectRandom',
            'script_setting',
            'mouseover',
            'get',
            'executeScript',
            'maxiSize',
            'windowChange',
            'windowSize',
            'windowScroll',
            'outputUrl',
            'output_datafile'
        ];
        $data = [];
        foreach($params as $param){
          $data[] = [
            'name' => $param,
            'created_at' => now(),
            'updated_at' => now()
          ];
        }
        DB::table('scenario_script_parameter_events')->insert($data);
    }
}
