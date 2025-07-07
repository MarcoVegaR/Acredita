<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Define entities to generate permissions for
     */
    protected array $entities = [
        'users',
        'roles',
        'permissions',
        'audits',
        'settings',
        'reports',
        // Add more entities as needed
    ];
    
    /**
     * Define available operations
     */
    protected array $operations = [
        'index',    // View list
        'create',   // Create new
        'show',     // View details
        'update',   // Edit existing
        'delete',   // Delete existing
        // Additional operations could be added here
    ];
    
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Generate permissions array
        $permissionsToCreate = [];
        $permissionNames = [];
        
        foreach ($this->entities as $entity) {
            foreach ($this->operations as $operation) {
                $permissionName = $entity . '.' . $operation;
                $permissionsToCreate[] = ['name' => $permissionName, 'guard_name' => 'web'];
                $permissionNames[] = $permissionName;
            }
        }
        
        // Add dashboard permission
        $permissionsToCreate[] = ['name' => 'dashboard.access', 'guard_name' => 'web'];
        $permissionNames[] = 'dashboard.access';
        
        // Use upsert for idempotent permission creation
        Permission::upsert(
            $permissionsToCreate,
            ['name', 'guard_name'],
            []
        );
        
        $this->command->info('Created/updated ' . count($permissionsToCreate) . ' permissions.');
        
        // Reset cache after creating permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        
        // Create Administrator role using firstOrCreate to avoid duplicates
        $role = Role::firstOrCreate(['name' => 'Administrator', 'guard_name' => 'web']);
        
        // Sync all permissions to Administrator role
        $role->syncPermissions($permissionNames);
        
        // Reset cache after assigning permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        
        $this->command->info('Administrator role created and permissions assigned successfully.');
    }
}
