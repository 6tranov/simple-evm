<?php

use Illuminate\Database\Seeder;

class TasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // 初期化
        DB::table('tasks')->delete();
        
        //最初のプロジェクトのidを取得
        $projects = DB::table('projects')->get();
        
        for ($i = 0; $i < 3; $i++) {
             $project_id = $projects[$i]->id;
            // テストデータ挿入
            DB::table('tasks')->insert(
                [
                    'due_on' => '2021-1-1',
                    'planned_value' => 30,
                    'project_id' => $project_id,
                    'name' => 'task1'
                ]
            );
        
            $tasks = DB::table('tasks')->get();
            $first_task_id = $tasks[0]->id;
        
            DB::table('tasks')->insert(
                [
                    'due_on' => '2021-1-1',
                    'planned_value' => 30,
                    'project_id' => $project_id,
                    'previous_task_id' => $first_task_id,
                    'name' => 'task2'
                ]
            );
        
            $tasks = DB::table('tasks')->get();
            $second_task_id = $tasks[1]->id;
        
            DB::table('tasks')->insert(
                [
                    'due_on' => '2021-2-1',
                    'planned_value' => 30,
                    'project_id' => $project_id,
                    'previous_task_id' => $second_task_id,
                    'name' => 'task3'
                ]
            );
        }
        
    }
}
