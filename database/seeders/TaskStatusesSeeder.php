<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskStatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tasks_status')->insert([
            [
                'id'=> 1,
                'name'=> 'Pending',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'id'=> 2,
                'name'=> 'Completed',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'id'=> 3,
                'name'=> 'Overdue',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'id'=> 4,
                'name'=> 'Cancelled',
                'created_at'=> now(),
                'updated_at'=> now(),
            ]
        ]);
    }
}
