<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arr = [];
        for($i=0;$i<50;$i++){
            $tmp = [];
            $tmp['name'] = str_random(15);
            $tmp['email'] = str_random(8).'@feisu.com';
            $tmp['password'] = Hash::make('ery0704');
            $tmp['remember_token'] = str_random(50);
            $tmp['profile'] = '/images/20190129/15487292763568.png';
            $tmp['intro'] = str_random(100);
            $tmp['created_at'] = date('Y-m-d H:i:s');
            $tmp['updated_at'] = date('Y-m-d H:i:s');
            $arr[] = $tmp;
        }
        DB::table('users')->insert($arr);
    }
}
