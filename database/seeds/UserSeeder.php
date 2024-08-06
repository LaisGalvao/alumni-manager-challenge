<?php

namespace Database\seeds;

use App\Models\Group;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $id = Str::uuid();
        DB::table('users')->insert(['id' => $id, 'name' =>'Super Admin', 'email' =>'dev.laisgalvao@gmail.com', 'password' => Hash::make('teste@123'), 'telephone' =>'(99)99999-9999', 'cpf' => '000.000.000-00']);
        $user = User::find($id);
        $user->groups()->attach(Group::where('key','like', 'Super Admin')->pluck('id'));

        $id = Str::uuid();
        DB::table('users')->insert(['id' => $id, 'name' =>'Administrador', 'email' =>'laisgbueno62@gmail.com', 'password' => Hash::make('adm@2024'), 'telephone' =>'(99)99999-9999', 'cpf' => '123.456.789-00']);
        $user = User::find($id);
        $user->groups()->attach(Group::where('key','like', 'Admin')->pluck('id'));
    }
}
