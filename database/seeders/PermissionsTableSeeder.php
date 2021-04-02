<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Config;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $db_permission = Permission::all()->pluck('name')->toArray();
        $feature_list = Config('constant.feature_list');
        $permission = [];
        $path = app_path() . "/Models";
        $model_list = [];
        $results = scandir($path);
        if(!empty($results)){
            foreach ($results as $result) {
                if ($result === '.' or $result === '..') continue;
                $filename = strtolower($result);
                $model_list[] = substr($filename,0,-4);
            }
        }
      
        if(!empty($model_list)){
            foreach ($model_list as $idfn) {
                foreach($feature_list as $pr){
                    $x = [];
                    $x['display_name'] = ucfirst(str_replace('_',' ' , $pr)).' '.ucfirst(str_replace('_',' ' , $idfn));
                    $x['name'] = $pr.'_'.$idfn;
                    $x['description'] = "Permission to ".ucfirst(str_replace('_',' ' , $pr)).' '.ucfirst(str_replace('_',' ' , $idfn));
                    $x['identifier'] = $idfn;
                    $permission[]  = $x;
                }
            }
        }
    	foreach ($permission as $key => $value){
            if(!in_array($value['name'], $db_permission)){
    		  Permission::create($value);
            }
    	}
    }
}
