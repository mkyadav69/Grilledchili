<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        $db_admins = User::all()->pluck('email')->toArray();
        $super_admin = Role::where('name', 'super-admin')->first();
        if(!in_array('admin@office.com', $db_admins)) {
            /*Super User*/
            $super_admin = User::create([                  
                'id' => 1,
                'first_name'=>'SuperAdmin',
                'last_name'=> 'SuperAdmin',
                'user_name'=> 'suadmin',
                'email'=> 'admin@office.com',
                'email_verified_at'=>null,
                'password'=>bcrypt('123456'),
                'cc_email'=>'admin@office.com',
                'branch_id'=>1,
                'remember_token'=>'nGSxaRYRMFm02Sqcaj8h3cc2deHdxFIn2O4cF57ce4L6Q76c0pJeeifN9TOO',
                'dt_created'=> Carbon::now(),
                'dt_modify'=> Carbon::now(),
                'in_deleted'=> 0,
            ]);
            $super_admin->attachRole($super_admin);
        }
    }
}