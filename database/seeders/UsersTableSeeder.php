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
        if(!in_array('admin@office.com', $db_admins)) {
            /*Super User*/
            $super_admin = User::create([                  
                'id' => 33,
                'email'=> 'admin@grilledchili.com',
                'password'=>bcrypt('123456'),
                'created_at'=> Carbon::now(),
                'created_at'=> Carbon::now(),
            ]);
        }
    }
}