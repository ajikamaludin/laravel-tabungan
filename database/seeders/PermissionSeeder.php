<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            ['id' => Str::ulid(), 'label' => 'View Dashboard', 'name' => 'view-dashboard'],

            ['id' => Str::ulid(), 'label' => 'Create User', 'name' => 'create-user'],
            ['id' => Str::ulid(), 'label' => 'Update User', 'name' => 'update-user'],
            ['id' => Str::ulid(), 'label' => 'View User', 'name' => 'view-user'],
            ['id' => Str::ulid(), 'label' => 'Delete User', 'name' => 'delete-user'],

            ['id' => Str::ulid(), 'label' => 'Create Role', 'name' => 'create-role'],
            ['id' => Str::ulid(), 'label' => 'Update Role', 'name' => 'update-role'],
            ['id' => Str::ulid(), 'label' => 'View Role', 'name' => 'view-role'],
            ['id' => Str::ulid(), 'label' => 'Delete Role', 'name' => 'delete-role'],

            ['id' => Str::ulid(), 'label' => 'View Setting', 'name' => 'view-setting'],

            ['id' => Str::ulid(), 'label' => 'Create Nasabah', 'name' => 'create-customer'],
            ['id' => Str::ulid(), 'label' => 'Update Nasabah', 'name' => 'update-customer'],
            ['id' => Str::ulid(), 'label' => 'View Nasabah', 'name' => 'view-customer'],
            ['id' => Str::ulid(), 'label' => 'Delete Nasabah', 'name' => 'delete-customer'],

            ['id' => Str::ulid(), 'label' => 'Create Setoran', 'name' => 'create-debit'],
            ['id' => Str::ulid(), 'label' => 'View Setoran', 'name' => 'view-debit'],
            ['id' => Str::ulid(), 'label' => 'Delete Setoran', 'name' => 'delete-debit'],

            ['id' => Str::ulid(), 'label' => 'Create Penarikan', 'name' => 'create-credit'],
            ['id' => Str::ulid(), 'label' => 'View Penarikan', 'name' => 'view-credit'],
            ['id' => Str::ulid(), 'label' => 'Delete Penarikan', 'name' => 'delete-credit'],
        ];

        foreach ($permissions as $permission) {
            Permission::insert($permission);
        }

        $role = Role::create(['name' => 'admin']);

        $permissions = Permission::all();
        foreach ($permissions as $permission) {
            $role->rolePermissions()->create(['permission_id' => $permission->id]);
        }

        User::create([
            'name' => 'Super Administrator',
            'email' => 'root@admin.com',
            'password' => bcrypt('password'),
        ]);

        $admin = User::create([
            'name' => 'Administator',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
            'role_id' => $role->id,
        ]);

        $setting = [];

        Setting::insert($setting);
    }
}
