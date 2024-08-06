<?php

namespace Database\seeds;

use App\Models\Group;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $id = Str::uuid();
        DB::table('groups')->insert( ['id' => $id, 'key' => 'Super Admin', 'type' => 'cargo', 'description' => 'Pessoas responsáveis com todas as funcionalidades']);
        $group = Group::find($id);
        $group->roles()->attach(Role::all()->pluck('id'));


        $old = $id;
        $id = Str::uuid();
        DB::table('groups')->insert( ['id' => $id, 'master_group_id'=>$old, 'key' => 'Admin', 'type' => 'cargo', 'description' => 'Pessoas com permissão de administrador']);
        $group = Group::find($id);
        $group->roles()->attach(Role::all()->pluck('id'));

        $old = $id;
        $id = Str::uuid();
        DB::table('groups')->insert(['id' => $id, 'key' => 'Contractor', 'type' => 'ator', 'description' => 'Empresa que esta procurando um empregado', 'master_group_id' => $old, 'public' => 1]);
        $group = Group::find($id);
        $group->roles()->attach(Role::where('key','like','index.group.api')->pluck('id'));
        $group->roles()->attach(Role::where('key','like','index.user.group.api')->pluck('id'));
        $group->roles()->attach(Role::where('key','like','index.user.api')->pluck('id'));
        $group->roles()->attach(Role::where('key','like','create.auth.api')->pluck('id'));
        $group->roles()->attach(Role::where('key','like','edit.auth.api')->pluck('id'));
        $group->roles()->attach(Role::where('key','like','%object%')->pluck('id'));
        
        
        $id = Str::uuid();
        DB::table('groups')->insert(['id' => $id, 'key' => 'Employee', 'type' => 'ator', 'description' => 'Pessoa que esta procuranco um emprego', 'master_group_id' => $old, 'public' => 1]);
        $group = Group::find($id);
        $group->roles()->attach(Role::where('key','like','index.object.api')->pluck('id'));
        $group->roles()->attach(Role::where('key','like','update.object.api')->pluck('id'));
        $group->roles()->attach(Role::where('key','like','linkuser.object.api')->pluck('id'));
        $group->roles()->attach(Role::where('key','like','show.object.api')->pluck('id'));
    }
}
