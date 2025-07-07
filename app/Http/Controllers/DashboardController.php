<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DashboardController extends BaseController
{
    /**
     * Mostrar el dashboard con datos dinámicos de roles y usuarios
     */
    public function index(Request $request): Response
    {
        // Obtener estadísticas reales de usuarios
        $totalUsers = User::count();
        $newUsersLastMonth = User::where('created_at', '>=', now()->subMonth())->count();
        $percentageChange = $totalUsers > 0 
            ? round(($newUsersLastMonth / $totalUsers) * 100, 1)
            : 0;
        
        // Obtener estadísticas de roles y permisos
        $roles = Role::withCount('users')->get();
        $totalRoles = $roles->count();
        $totalPermissions = Permission::count();
        
        // Agrupar usuarios por rol para mostrar distribución
        $roleDistribution = $roles->map(function($role) use ($totalUsers) {
            return [
                'name' => $role->name,
                'count' => $role->users_count,
                'percentage' => $totalUsers > 0 
                    ? round(($role->users_count / $totalUsers) * 100, 1)
                    : 0
            ];
        });
        
        return Inertia::render('dashboard', [
            'stats' => [
                'usuarios' => [
                    'total' => $totalUsers,
                    'nuevos' => $newUsersLastMonth,
                    'crecimiento' => $percentageChange,
                    'tendencia' => $percentageChange >= 0 ? 'increase' : 'decrease',
                ],
                'roles' => [
                    'total' => $totalRoles,
                    'distribucion' => $roleDistribution,
                ],
                'permisos' => [
                    'total' => $totalPermissions,
                ],
            ],
        ]);
    }
}
