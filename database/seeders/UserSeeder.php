<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Orchid\Platform\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::createAdmin('test_admin', 'admin@admin.com', 'admin');
//        User::where('email', 'admin@admin.com')->update(['username' => 'test_admin']);
    }
}
