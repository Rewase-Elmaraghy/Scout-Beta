<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        //factory('App\User',1)->create();
		App\User::insert(['name'=>'admin','email'=>'admin@admin.admin','password'=>'$2y$10$LLG7eFxyPKHknXrav.2Q3eZ9f7kYS178YimWVjWTbP68aXk59IUFG']);
    }
}
