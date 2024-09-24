<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Article;
use App\Models\Comment;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::create(['name' => 'writer']);
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'user']);

        User::factory(10)->create();
        Article::factory(10)->create();
        Comment::factory(10)->create();



        $user = new User();
        $user->name = "Victor";
        $user->surname = "Vera";
        $user->username = "Vittorio";
        $user->email = "victor@correo.es";
        $user->photo = "https://github.com/turbrecher.png";
        $user->password = Hash::make("12345678");

        $user->assignRole("admin");


        $user->save();
    }
}
