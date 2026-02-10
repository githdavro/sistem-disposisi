<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use App\Models\Unit;
use Illuminate\Support\Facades\Hash;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'unit-list',
            'unit-create',
            'unit-edit',
            'unit-delete',
            'surat-list',
            'surat-create',
            'surat-edit',
            'surat-delete',
            'surat-approve',
            'surat-reject',
            'dashboard-view',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions
        $adminRole = Role::create(['name' => 'Admin']);
        $adminRole->givePermissionTo(Permission::all());

        $unitRole = Role::create(['name' => 'Unit']);
        $unitRole->givePermissionTo([
            'surat-list',
            'surat-create',
            'surat-edit',
            'dashboard-view',
        ]);

        $pengadaanRole = Role::create(['name' => 'Pengadaan']);
        $pengadaanRole->givePermissionTo([
            'surat-list',
            'surat-edit',
            'dashboard-view',
        ]);

        $direkturRole = Role::create(['name' => 'Direktur']);
        $direkturRole->givePermissionTo([
            'surat-list',
            'surat-approve',
            'surat-reject',
            'dashboard-view',
        ]);

        // Create units
        $unit1 = Unit::create(['nama_unit' => 'Unit 1']);
        $unit2 = Unit::create(['nama_unit' => 'Unit 2']);
        $unit3 = Unit::create(['nama_unit' => 'Unit 3']);

        // Create admin user
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@sistem.com',
            'password' => Hash::make('password'),
        ]);
        $admin->assignRole('Admin');

        // Create unit users
        $userUnit1 = User::create([
            'name' => 'User Unit 1',
            'email' => 'unit1@sistem.com',
            'password' => Hash::make('password'),
            'unit_id' => $unit1->id,
        ]);
        $userUnit1->assignRole('Unit');

        $userUnit2 = User::create([
            'name' => 'User Unit 2',
            'email' => 'unit2@sistem.com',
            'password' => Hash::make('password'),
            'unit_id' => $unit2->id,
        ]);
        $userUnit2->assignRole('Unit');

        $userUnit3 = User::create([
            'name' => 'User Unit 3',
            'email' => 'unit3@sistem.com',
            'password' => Hash::make('password'),
            'unit_id' => $unit3->id,
        ]);
        $userUnit3->assignRole('Unit');

        // Create pengadaan user
        $pengadaan = User::create([
            'name' => 'User Pengadaan',
            'email' => 'pengadaan@sistem.com',
            'password' => Hash::make('password'),
        ]);
        $pengadaan->assignRole('Pengadaan');

        // Create direktur user
        $direktur = User::create([
            'name' => 'Direktur',
            'email' => 'direktur@sistem.com',
            'password' => Hash::make('password'),
        ]);
        $direktur->assignRole('Direktur');
    }
}