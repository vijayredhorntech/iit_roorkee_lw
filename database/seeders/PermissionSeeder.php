<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create PI-related permissions
        $permissions = [
            'view pi',
            'edit pi',
            'create pi',
            'delete pi',

            'edit lab',
            'create lab',
            'delete lab',

            'view student',
            'edit student',
            'create student',
            'delete student',

            'view instrumentCategory',
            'edit instrumentCategory',
            'create instrumentCategory',
            'delete instrumentCategory',

            'view instrument',
            'edit instrument',
            'create instrument',
            'delete instrument',

            'create bookings',
            'view bookings',
            'delete bookings',

            'create instrument complaint',
            'view instrument complaint',
            'update instrument complaint',

            'raise instrument service request',
            'view instrument service request',
            'update instrument service request',

            'view instrument services',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Get roles
        $superAdminRole = Role::findByName('super_admin');
        $piRole = Role::findByName('pi');
        $studentRole = Role::findByName('student');

        // Assign permissions to super_admin role
        $superAdminRole->givePermissionTo($permissions);

        // Assign view and edit permissions to pi role
        $piRole->givePermissionTo(
            [ 'view pi',
              'edit pi',
                'edit lab',
                'create lab',
                'delete lab',
                'view student',
                'edit student',
                'create student',
                'delete student',
                'view instrumentCategory',
                'edit instrumentCategory',
                'create instrumentCategory',
                'delete instrumentCategory',
                'view instrument',
                'edit instrument',
                'create instrument',
                'delete instrument',
                'create bookings',
                'view bookings',
                'delete bookings',
                'create instrument complaint',
                'view instrument complaint',
                'update instrument complaint',
                'view instrument services'
            ]
        );

        // Assign view permission to student role
        $studentRole->givePermissionTo(
            [
                'view bookings',
                'create bookings',
                'delete bookings',
                'view instrument',
                'create instrument complaint',
                'view instrument complaint',
            ]
        );
    }
}
