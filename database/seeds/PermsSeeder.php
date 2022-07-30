<?php

use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()['cache']->forget('spatie.permission.cache');
        Permission::create(['name' => 'view_users']);
        Permission::create(['name' => 'edit_users']);

        Permission::create(['name' => 'configuration']);

        
        $admins = Role::create(['name' => 'administrador']);
        $admins->givePermissionTo('view_users');
        $admins->givePermissionTo('edit_users');
        $admins->givePermissionTo('configuration');

        $customer = Role::create(['name' => 'cliente']);
        
    }
}
