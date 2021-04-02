<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;
use Carbon\Carbon;
class RolesTableSeeder extends Seeder
{
    public function run()
    {
        
        $db_role = Role::all()->pluck('name')->toArray();
        $all_permission = Permission::all();
        $perm_list = $all_permission->toArray();
        $specific_permision=[];
        foreach($all_permission as $permission) {
            $specific_permision[$permission->name] = $permission;
        }
        if(!in_array('super-admin', $db_role)) {
            /*Super Admin*/
            $su_role = Role::create([
                'display_name' => 'Super Admin',
                'name' => 'super-admin',
                'description' => 'Has access for every operation !'
            ]);
            $arr = [];
            foreach ($perm_list as $key => $value) {
                $su_role->attachPermission($specific_permision[$value['name']]);
            }
        }
	}
}