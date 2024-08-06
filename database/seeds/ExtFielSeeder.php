<?php


namespace Database\seeds;

use App\Models\Group;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ExtFielSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    /*    $contractor = Group::where('key', 'Contractor')->first();

        $id = Str::uuid();
        DB::table('extra_fields')->insert( ['id' => $id, 'description' => 'Style Colors', 'type_value' => 'master', 'type' => 'group', 'group_id' => $contractor, 'key' => 'style_colors']);

        DB::table('extra_fields')->insert( ['id' => Str::uuid(), 'description' => 'Cor do plano de fundo', 'type_value' => 'color', 'type' => 'master', 'master_extra_field' => $id, 'key' => 'cor_plano_de_fundo']);
    */
        
    }
}
