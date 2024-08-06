<?php

namespace Database\seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert( ['id' => Str::uuid(), 'key' => 'create.role.api', 'description' => 'Funcionalidade que permite criar rotas de funcionalidade']);
        DB::table('roles')->insert( ['id' => Str::uuid(), 'key' => 'linkgroup.role.api', 'description' => 'Funcionalidade que permite liberar rotas de funcionalidade a um grupo']);
        DB::table('roles')->insert( ['id' => Str::uuid(), 'key' => 'index.role.api', 'description' => 'Funcionalidade que permite um usuário ver todas as regras que ele tem acesso']);

        DB::table('roles')->insert( ['id' => Str::uuid(), 'key' => 'create.group.api', 'description' => 'Funcionalidade que permite criar um grupo']);
        DB::table('roles')->insert( ['id' => Str::uuid(), 'key' => 'update.group.api', 'description' => 'Funcionalidade que permite editar um grupo']);
        DB::table('roles')->insert( ['id' => Str::uuid(), 'key' => 'show.group.api', 'description' => 'Funcionalidade que permite ver um grupo']);
        DB::table('roles')->insert( ['id' => Str::uuid(), 'key' => 'linkuser.group.api', 'description' => 'Funcionalidade que associa um usuário a um grupo']);
        DB::table('roles')->insert( ['id' => Str::uuid(), 'key' => 'index.user.group.api', 'description' => 'Funcionalidade que permite um usuário ver todas os grupos que um usuário faz parte']);
        DB::table('roles')->insert( ['id' => Str::uuid(), 'key' => 'index.group.api', 'description' => 'Funcionalidade que permite um usuário ver todas os grupos que ele faz parte']);

        DB::table('roles')->insert( ['id' => Str::uuid(), 'key' => 'create.auth.api', 'description' => 'Funcionalidade que permite um usuário criar outros usuários']);
        DB::table('roles')->insert( ['id' => Str::uuid(), 'key' => 'edit.auth.api', 'description' => 'Funcionalidade que permite editar um usuário']);
        DB::table('roles')->insert( ['id' => Str::uuid(), 'key' => 'show.user.api', 'description' => 'Funcionalidade que permite um usuário ver as informações de outro usuário']);
        DB::table('roles')->insert( ['id' => Str::uuid(), 'key' => 'index.user.api', 'description' => 'Funcionalidade que permite um usuário ver todos usuários dentro dos seus grupos']);
        DB::table('roles')->insert( ['id' => Str::uuid(), 'key' => 'reset_password.user.api', 'description' => 'Funcionalidade que permite um usuário alterar sua senha']);
        DB::table('roles')->insert( ['id' => Str::uuid(), 'key' => 'delete.user.api', 'description' => 'Funcionalidade que deleta um usuário.']);
        
        DB::table('roles')->insert( ['id' => Str::uuid(), 'key' => 'create.extraField.api', 'description' => 'Funcionalidade que permite criar um extra field']);
        DB::table('roles')->insert( ['id' => Str::uuid(), 'key' => 'update.extraField.api', 'description' => 'Funcionalidade que permite editar um extra field']);
        DB::table('roles')->insert( ['id' => Str::uuid(), 'key' => 'user.extraField.api', 'description' => 'Funcionalidade que retorna todos os campos extras de um usuário']);
        DB::table('roles')->insert( ['id' => Str::uuid(), 'key' => 'delete.user.extraField.api', 'description' => 'Funcionalidade que deleta um valor de campo extra de um usuário.']);
        DB::table('roles')->insert( ['id' => Str::uuid(), 'key' => 'useringroup.extraField.api', 'description' => 'Funcionalidade que retorna todos os campos extras para os usuário de um grupo']);
        DB::table('roles')->insert( ['id' => Str::uuid(), 'key' => 'delete.extraField.api', 'description' => 'Funcionalidade que permite deletar os valores de campo extra de um usuário']);

        DB::table('roles')->insert( ['id' => Str::uuid(), 'key' => 'delete.extra_field_value.api', 'description' => 'Funcionalidade que permite um usuário deletar valores de um campo extra.']);
        
        DB::table('roles')->insert( ['id' => Str::uuid(), 'key' => 'create.message.api', 'description' => 'Funcionalidade que permite um usuário mandar uma mensagens para um grupo o mais']);
        DB::table('roles')->insert( ['id' => Str::uuid(), 'key' => 'index.message.api', 'description' => 'Funcionalidade que permite um usuário ver todas as mensagens recebidas']);
        DB::table('roles')->insert( ['id' => Str::uuid(), 'key' => 'index.priority.message.api', 'description' => 'Funcionalidade que permite um usuário ver todas as mensagens recebidas que tem prioridade']);
        DB::table('roles')->insert( ['id' => Str::uuid(), 'key' => 'show.message.api', 'description' => 'Funcionalidade que permite um usuário ver uma mensagem de um grupo que ele faz parte']);
                
        DB::table('roles')->insert( ['id' => Str::uuid(), 'key' => 'show.image.api', 'description' => 'Funcionalidade que permite um usuário ver sua imagem de perfil']);
        DB::table('roles')->insert( ['id' => Str::uuid(), 'key' => 'upload.image.api', 'description' => 'Funcionalidade que permite um usuário carregar sua imagem de perfil']);
        DB::table('roles')->insert( ['id' => Str::uuid(), 'key' => 'upload.logo.api', 'description' => 'Funcionalidade que permite fazer o upload de um logo']);    

        DB::table('roles')->insert( ['id' => Str::uuid(), 'key' => 'index.object.api', 'description' => 'Funcionalidade que permite um usuário ver todos objetos por um filtro']);
        DB::table('roles')->insert( ['id' => Str::uuid(), 'key' => 'create.object.api', 'description' => 'Funcionalidade que permite um usuário criar objeto']);
        DB::table('roles')->insert( ['id' => Str::uuid(), 'key' => 'update.object.api', 'description' => 'Funcionalidade que permite um usuário editar objeto']);
        DB::table('roles')->insert( ['id' => Str::uuid(), 'key' => 'linkgroup.object.api', 'description' => 'Funcionalidade que permite um usuário linkar um objeto a um grupo']);
        DB::table('roles')->insert( ['id' => Str::uuid(), 'key' => 'linkuser.object.api', 'description' => 'Funcionalidade que permite um usuário linkar um objeto a um usuario']);
        DB::table('roles')->insert( ['id' => Str::uuid(), 'key' => 'linkobject.object.api', 'description' => 'Funcionalidade que permite um usuário linkar um objeto a um outro objeto']);
        DB::table('roles')->insert( ['id' => Str::uuid(), 'key' => 'show.object.api', 'description' => 'Funcionalidade que permite um usuário ver um objeto']);
    }
}
