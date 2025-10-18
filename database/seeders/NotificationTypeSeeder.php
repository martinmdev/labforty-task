<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotificationTypeSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('notification_type')->insert([
            [
                'name' => 'Email',
            ],
            [
                'name' => 'SMS',
            ],
//            [
//                'name' => 'Push-Notification',
//            ],
        ]);
    }
}
